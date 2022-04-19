<?php

use App\Http\Controllers\RestApi\v1\AllTestsController;
use App\Http\Controllers\RestApi\v1\AuthController;
use App\Http\Controllers\RestApi\v1\ProjectController;
use App\Http\Controllers\RestApi\v1\TestController;
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

Route::prefix('v1')->group(function () {
    // Protected routes - Laravel sanctum token authentication
    Route::group(['middleware' => ['auth:sanctum', 'api']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/tests', [AllTestsController::class, 'index']);
        Route::get('/tests/search/{str}', [AllTestsController::class, 'search']);
        Route::post('/tests/run/all', [AllTestsController::class, 'create']);

        Route::get('/tests/{test_id}', [TestController::class, 'show']);
        Route::post('/tests/run/specific', [TestController::class, 'create']);

        Route::get('/projects', [ProjectController::class, 'index']);
        Route::get('/projects/search/{str}', [ProjectController::class, 'search']);
        Route::get('/project/{project_id}', [ProjectController::class, 'show']);
        Route::put('/verify/{project:slug}', [ProjectController::class, 'update']);
        Route::post('/dashboard/add-project', [ProjectController::class, 'create']);

        // Route::get('/tests/run/all/{project_id}', [AllTestsController::class, 'create']);
        // Route::get('/tests/run/{test_id}/{project_id}', [TestController::class, 'create']);
    });

    // Public routes
    Route::post('/login', [AuthController::class, 'login']);
});

// If incorrect route is called
Route::any('{path}', function () {
    return response()->json([
        'message' => 'Route not found',
    ], 404);
})->where('path', '.*');
