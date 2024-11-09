<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {

        try {

            $current_user = Auth::user();

            $query = User::query();
            if ($request->has('sort_field') && $request->has('sort_type')) {
                $sortField = $request->sort_field;
                $sortDirection = $request->sort_type;

                $query->orderBy($sortField, $sortDirection);
            }

            $limit = $request->has('limit') ? (int)$request->limit : 10;
            if ($limit > 50) {
                $limit = 50;
            }
            $users = $query->paginate($limit);

            return response()->json([
                'data' => $users
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
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $request->merge([
                "role" => "User"
            ]);
            $user = User::create($request->all());
            return response()->json($user, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }


    public function show($id)
    {

        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json([
                "error" => "user not found"
            ]);
        }

        return response()->json([
            "user" => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json([
            "user" => $user
        ], 200);
    }


    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $user->delete();
        return response()->json([
            "message" => "successfully deleted user"
        ], 200);
    }
}
