<?php
// DecisionTreeController.php
namespace App\Http\Controllers;

use App\Services\DecisionTreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DecisionTreeController extends Controller
{
    protected $decisionTreeService;

    public function __construct(DecisionTreeService $decisionTreeService)
    {
        $this->decisionTreeService = $decisionTreeService;
    }

    // Predict with product recommendations
    public function predictWithRecommendations(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'harga' => 'required|string',
            'garansi' => 'required|string',
            'fitur' => 'required|string',
            'kualitas' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }


        $inputData = $validator->validated();


        $result = $this->decisionTreeService->getRecommendedProducts($inputData);

        return response()->json($result);
    }


    public function downloadReport()
    {
        return $this->decisionTreeService->downloadReport();
    }
}
