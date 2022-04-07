<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestApi\v1\AuthController;
use App\Http\Controllers\RestApi\v1\TestController;
use App\Http\Controllers\RestApi\v1\ProjectController;
use App\Http\Controllers\RestApi\v1\AllTestsController;

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

// Protected routes - Laravel sanctum token authentication
Route::group(['middleware' => ['auth:sanctum', 'api']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/tests', [AllTestsController::class, 'index']);
    Route::get('/tests/{test_id}', [TestController::class, 'show']);
    Route::get('/tests/search/{str}', [AllTestsController::class, 'search']);
    Route::get('/tests/run/all/{project_id}', [AllTestsController::class, 'create']);
    Route::get('/tests/run/{test_id}/{project_id}', [TestController::class, 'create']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/search/{str}', [ProjectController::class, 'search']);
    Route::get('/projects/{project_id}', [ProjectController::class, 'show']);
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// If incorrect route is called
Route::any('{path}', function() {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
})->where('path', '.*');
