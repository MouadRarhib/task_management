<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:128',
            'role' => 'required|string|max:64',
            'email' => 'required|email|unique:users,email|max:128',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity status code
        }

        try {
            $user = User::create([
                'full_name' => $request->input('full_name'),
                'role' => $request->input('role'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            return response()->json($user, 201); // 201 Created status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve user',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:128',
            'role' => 'required|string|max:64',
            'email' => 'required|email|unique:users,email,' . $id . ',pkid_user|max:128',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::findOrFail($id);

            $user->full_name = $request->input('full_name');
            $user->role = $request->input('role');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            return response()->json($user, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Attempt to force delete the user
            $user->forceDelete();

            // Verify if the user still exists after deletion
            $exists = User::withTrashed()->find($id);

            if ($exists) {
                return response()->json([
                    'message' => 'User could not be deleted due to existing constraints.',
                ], 500); // 500 Internal Server Error status code
            } else {
                return response()->json([
                    'message' => 'User successfully deleted',
                ], 200); // 200 OK status code
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }
}
