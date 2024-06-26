<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();
        return response()->json($statuses);
    }

    public function store(Request $request)
    {
        $status = Status::create($request->all());
        return response()->json($status, 201);
    }

    public function show($id)
    {
        $status = Status::find($id);
        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        return response()->json($status);
    }

    public function update(Request $request, $id)
    {
        $status = Status::find($id);
        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        $status->update($request->all());
        return response()->json($status);
    }

    public function destroy($id)
    {
        $status = Status::find($id);
        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        $status->delete();
        return response()->json(['message' => 'Status deleted']);
    }
}
