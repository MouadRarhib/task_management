<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::all();
            return response()->json($tasks, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve tasks',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'fkid_status' => 'required|exists:statuses,pkid_status',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity status code
        }

        try {
            $task = Task::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'fkid_status' => $request->input('fkid_status'),
            ]);

            return response()->json($task, 201); // 201 Created status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create task',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);
            return response()->json($task, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve task',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'fkid_status' => 'required|exists:statuses,pkid_status',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity status code
        }

        try {
            $task = Task::findOrFail($id);

            $task->name = $request->input('name');
            $task->description = $request->input('description');
            $task->fkid_status = $request->input('fkid_status');

            $task->save();

            return response()->json($task, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update task',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);

            // Attempt to force delete the task
            $task->forceDelete();

            // Verify if the task still exists after deletion
            $exists = Task::withTrashed()->find($id);

            if ($exists) {
                return response()->json([
                    'message' => 'Task could not be deleted due to existing constraints.',
                ], 500); // 500 Internal Server Error status code
            } else {
                return response()->json([
                    'message' => 'Task successfully deleted',
                ], 200); // 200 OK status code
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage(),
            ], 404); // 404 Not Found status code
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete task',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    }


    // add task to user 
    // add user to team 
    // add project to team 
}
