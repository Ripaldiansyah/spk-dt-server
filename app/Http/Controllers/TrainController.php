<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\Request;
use Exception;

class TrainController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trains = Train::all();
            return response()->json(['data' => $trains], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {

        try {
            $train = Train::create($request->all());
            return response()->json(['data' => $train], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $train = Train::find($id);
            if (!$train) {
                return response()->json(['message' => 'Train not found'], 404);
            }
            return response()->json(['data' => $train], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {


        try {

            $train = Train::find($id);
            if (!$train) {
                return response()->json(['message' => 'Train not found'], 404);
            }

            $train->update($request->all());
            return response()->json(['data' => $train], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $train = Train::find($id);
            if (!$train) {
                return response()->json(['message' => 'Train not found'], 404);
            }

            $train->delete();
            return response()->json(['message' => 'Train deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
