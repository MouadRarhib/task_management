<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index()
    {
        try {
            $teams = Team::all();
            return response()->json($teams, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve teams',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); 
        }

        try {
            $team = Team::create($request->all());
            return response()->json($team, 201); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create team',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function show($id)
    {
        try {
            $team = Team::findOrFail($id);
            return response()->json($team, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve team',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); 
        }

        try {
            $team = Team::findOrFail($id);
            $team->update($request->all());
            return response()->json($team, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found',
                'error' => $e->getMessage(),
            ], 404); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update team',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function destroy($id)
    {
        try {
            $team = Team::findOrFail($id);
    
            // Attempt to force delete the team
            $team->forceDelete();
    
            // Verify if the team still exists after deletion
            $exists = Team::withTrashed()->find($id);
    
            if ($exists) {
                return response()->json([
                    'message' => 'Team could not be deleted due to existing constraints.',
                ], 500); // 500 Internal Server Error status code
            } else {
                return response()->json([
                    'message' => 'Team successfully deleted',
                ], 200); // 200 OK status code
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete team',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }
    
}
