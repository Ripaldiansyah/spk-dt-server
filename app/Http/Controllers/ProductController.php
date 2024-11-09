<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $productsQuery = Product::query();
            if ($request->has('sort_field') && $request->has('sort_type')) {
                $sortField = $request->sort_field;
                $sortDirection = $request->sort_type;
                $productsQuery->orderBy($sortField, $sortDirection);
            }
            $limit = $request->has('limit') ? (int)$request->limit : 14;
            if ($limit > 50) {
                $limit = 50;
            }

            $products = $productsQuery->paginate($limit);

            return response()->json([
                'data' => $products
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'product_name' => 'required|string|max:50',
                'harga' => 'required',
                'garansi' => 'required|string|max:50',
                'fitur' => 'required|string|max:50',
                'kualitas' => 'required|string|max:50',
                'photo' => 'required|string|max:100',
            ]);
            $product = Product::where('product_name', $request->product_name)->first();
            if ($product) {
                return response()->json(['message' => 'Product already exists'], 400);
            }

            $product_create = [
                'product_name' => $request->product_name,
                'harga' => $request->harga,
                'garansi' => $request->garansi,
                'fitur' => $request->fitur,
                'kualitas' => $request->kualitas,
                'photo' => $request->photo
            ];

            $product = Product::create($product_create);
            return response()->json(['data' => $product], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate(['product_name' => 'required|string|max:50']);

        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $isProductRegistered = Product::where('product_name', $request->product_name)->where('id', '!=', $id)->first();
            if ($isProductRegistered) {
                return response()->json(['message' => 'Product already exists'], 400);
            }

            $product->update($request->all());
            return response()->json(['data' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
