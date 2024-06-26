<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Status Routes
Route::get('statuses/all', [StatusController::class, 'index']);
Route::post('statuses/store', [StatusController::class, 'store']);
Route::get('statuses/{id}', [StatusController::class, 'show']);
Route::put('statuses/update/{id}', [StatusController::class, 'update']);
Route::delete('statuses/delete/{id}', [StatusController::class, 'destroy']);

// Task Routes
Route::get('tasks/all', [TaskController::class, 'index']);
Route::post('tasks/store', [TaskController::class, 'store']);  // url = http://127.0.0.1:8000     url + tasks/all

Route::get('tasks/{id}', [TaskController::class, 'show']);
Route::put('tasks/update/{id}', [TaskController::class, 'update']);
Route::delete('tasks/delete/{id}', [TaskController::class, 'destroy']);

// User Routes
Route::get('users/all', [UserController::class, 'index']);
Route::post('users/store', [UserController::class, 'store']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::put('users/update/{id}', [UserController::class, 'update']);
Route::delete('users/delete/{id}', [UserController::class, 'destroy']);

// Project Routes
Route::get('projects/all', [ProjectController::class, 'index']);
Route::post('projects/store', [ProjectController::class, 'store']);
Route::get('projects/{id}', [ProjectController::class, 'show']);
Route::put('projects/update/{id}', [ProjectController::class, 'update']);
Route::delete('projects/delete/{id}', [ProjectController::class, 'destroy']);

// Team Routes
Route::get('teams/all', [TeamController::class, 'index']);
Route::post('teams/store', [TeamController::class, 'store']);
Route::get('teams/{id}', [TeamController::class, 'show']);
Route::put('teams/update/{id}', [TeamController::class, 'update']);
Route::delete('teams/delete/{id}', [TeamController::class, 'destroy']);

// add user to team 

// add task to user 

// add project to team
