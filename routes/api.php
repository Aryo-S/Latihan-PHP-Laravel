<?php

use App\Http\Controllers\Api\V1\TasksController;
use App\Http\Controllers\Api\V1\CompleteTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// create an end-point for tasks, with a group previx for v1 so it will become /v1/tasks
// this is done so other routes can be grouped in /v1 prefix later on
Route::prefix('v1')->group(function() {
    Route::apiResource('/tasks', TasksController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class, 'complete');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});