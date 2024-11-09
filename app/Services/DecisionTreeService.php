<?php
// DecisionTreeService.php
namespace App\Services;

use App\Models\Product;
use App\Models\Train;
use Illuminate\Support\Collection;

class DecisionTreeService
{
    private function log2($number)
    {
        // Avoid log of 0 or negative numbers
        if ($number <= 0) {
            return 0;
        }

        return log($number, 2);
    }

    // Calculate Entropy for a given attribute
    public function calculateEntropy($data, $targetAttribute = 'prediction')
    {
        // Ensure $data is a collection
        $data = collect($data);
        $totalEntries = $data->count();

        // Handle empty dataset
        if ($totalEntries == 0) {
            return 0;
        }

        $classCounts = $data
            ->groupBy($targetAttribute)
            ->map(function ($group) use ($totalEntries) {
                return $group->count() / $totalEntries;
            });

        $entropy = $classCounts->reduce(function ($carry, $probability) {
            // Only calculate if probability is positive
            return $probability > 0
                ? $carry - ($probability * $this->log2($probability))
                : $carry;
        }, 0);

        return $entropy;
    }

    // Calculate Information Gain
    public function calculateInformationGain($data, $attribute, $targetAttribute = 'prediction')
    {
        // Ensure $data is a collection
        $data = collect($data);

        // Handle empty dataset
        if ($data->isEmpty()) {
            return 0;
        }

        $totalEntropy = $this->calculateEntropy($data, $targetAttribute);

        $attributeValues = $data
            ->groupBy($attribute)
            ->map(function ($group) use ($data, $attribute, $targetAttribute) {
                // Calculate weight based on group size relative to total data
                $weight = $group->count() / $data->count();
                $subEntropy = $this->calculateEntropy($group, $targetAttribute);
                return $weight * $subEntropy;
            });

        $informationGain = $totalEntropy - $attributeValues->sum();
        return $informationGain;
    }

    private function ensureCollection($data)
    {
        return is_array($data) ? collect($data) : $data;
    }

    // Select Best Attribute for Split
    public function selectBestAttribute($data, $attributes, $targetAttribute = 'prediction')
    {
        $data = $this->ensureCollection($data);

        $informationGains = collect($attributes)
            ->mapWithKeys(function ($attribute) use ($data, $targetAttribute) {
                return [$attribute => $this->calculateInformationGain($data, $attribute, $targetAttribute)];
            });

        return $informationGains->sortDesc()->keys()->first();
    }

    // Build Decision Tree
    public function buildDecisionTree($data, $attributes, $targetAttribute = 'prediction', $depth = 0)
    {
        $uniqueClasses = collect($data)->pluck($targetAttribute)->unique();

        // Stopping conditions
        if ($uniqueClasses->count() == 1) {
            return ['leaf' => true, 'class' => $uniqueClasses->first()];
        }

        if (empty($attributes) || $depth > 5) {
            return ['leaf' => true, 'class' => $this->getMajorityClass($data, $targetAttribute)];
        }

        $bestAttribute = $this->selectBestAttribute($data, $attributes, $targetAttribute);

        $tree = [
            'attribute' => $bestAttribute,
            'branches' => []
        ];

        $attributeValues = collect($data)->pluck($bestAttribute)->unique();

        foreach ($attributeValues as $value) {
            $subset = collect($data)->where($bestAttribute, $value);

            if ($subset->isEmpty()) {
                $tree['branches'][$value] = [
                    'leaf' => true,
                    'class' => $this->getMajorityClass($data, $targetAttribute)
                ];
            } else {
                $remainingAttributes = array_diff($attributes, [$bestAttribute]);
                $tree['branches'][$value] = $this->buildDecisionTree(
                    $subset->toArray(),
                    $remainingAttributes,
                    $targetAttribute,
                    $depth + 1
                );
            }
        }

        return $tree;
    }

    // Get Majority Class
    private function getMajorityClass($data, $targetAttribute)
    {
        return collect($data)
            ->groupBy($targetAttribute)
            ->sortByDesc(function ($group) {
                return count($group);
            })
            ->keys()
            ->first();
    }

    // Predict method
    public function predict($tree, $sample)
    {
        $node = $tree;

        while (!isset($node['leaf'])) {
            $attribute = $node['attribute'];
            $value = $sample[$attribute];

            if (!isset($node['branches'][$value])) {
                // If no matching branch, return majority class
                return $this->getMajorityClass(Train::all()->toArray(), 'prediction');
            }

            $node = $node['branches'][$value];
        }

        return $node['class'];
    }

    public function getRecommendedProducts($sample)
    {
        $tree = $this->trainModel();
        $prediction = $this->predict($tree, $sample);

        // Find matching training data
        $matchingTrainData = Train::where('harga', $sample['harga'])
            ->where('garansi', $sample['garansi'])
            ->where('fitur', $sample['fitur'])
            ->where('kualitas', $sample['kualitas'])
            ->where('prediction', $prediction)
            ->get();

        // Get recommended products based on matching train data
        $recommendedProducts = Product::whereIn(
            'id',
            $matchingTrainData->pluck('product_id')
        )->get();

        // If no exact matches, find similar products
        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = $this->findSimilarProducts($sample, $prediction);
        }

        return [
            'prediction' => $prediction,
            'input' => $sample,
            'recommended_products' => $recommendedProducts->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'harga' => $product->harga,
                    'garansi' => $product->garansi,
                    'fitur' => $product->fitur,
                    'kualitas' => $product->kualitas,
                    'photo' => $product->photo,
                ];
            })
        ];
    }

    // Train the model
    public function trainModel()
    {
        $trainingData = Train::all()->toArray();
        $attributes = ['harga', 'garansi', 'fitur', 'kualitas'];

        return $this->buildDecisionTree($trainingData, $attributes);
    }

    // Find similar products when exact matches are not found
    private function findSimilarProducts($inputData, $prediction)
    {
        // Relaxed matching criteria
        $query = Product::query();

        // Try to match as many criteria as possible
        if (isset($inputData['harga'])) {
            $query->where('harga', 'like', '%' . $this->mapHargaToNumericRange($inputData['harga']) . '%');
        }

        if (isset($inputData['garansi'])) {
            $query->where('garansi', $inputData['garansi']);
        }

        // Add more flexible matching
        $query->where(function ($q) use ($inputData) {
            // Match fitur and kualitas with some flexibility
            if (isset($inputData['fitur'])) {
                $q->where('fitur', $inputData['fitur'])
                    ->orWhere('fitur', 'like', '%' . $inputData['fitur'] . '%');
            }

            if (isset($inputData['kualitas'])) {
                $q->where('kualitas', $inputData['kualitas'])
                    ->orWhere('kualitas', 'like', '%' . $inputData['kualitas'] . '%');
            }
        });

        // Limit results
        return $query->limit(5)->get();
    }

    // Helper method to map harga category to numeric range
    private function mapHargaToNumericRange($hargaCategory)
    {
        switch ($hargaCategory) {
            case '1-5 Juta':
                return '1000000-5000000';
            case '6-10 Juta':
                return '6000000-10000000';
            case '11-15 Juta':
                return '11000000-15000000';
            default:
                return '';
        }
    }
}
