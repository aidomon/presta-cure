<?php

use App\Http\Controllers\RestApi\v1\AllTestsController;
use App\Http\Controllers\RestApi\v1\AuthController;
use App\Http\Controllers\RestApi\v1\ProjectHandleController;
use App\Http\Controllers\RestApi\v1\ProjectResultsController;
use App\Http\Controllers\RestApi\v1\ProjectsController;
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

        Route::get('/test/{test_id}', [TestController::class, 'show']);
        Route::post('/test/run/specific', [TestController::class, 'create']);

        Route::get('/tests', [AllTestsController::class, 'index']);
        Route::get('/tests/search/{str}', [AllTestsController::class, 'search']);
        Route::post('/tests/run/all', [AllTestsController::class, 'create']);

        Route::get('/project/{project_id}', [ProjectHandleController::class, 'show']);
        Route::delete('/project/{project_id}/delete', [ProjectHandleController::class, 'destroy']);
        Route::get('/project/{project_id}/results', [ProjectResultsController::class, 'index']);
        Route::put('/project/verify/{project_id}', [ProjectHandleController::class, 'update']);

        Route::get('/projects', [ProjectsController::class, 'index']);
        Route::get('/projects/search/{str}', [ProjectsController::class, 'search']);
        Route::post('/projects/add-project', [ProjectsController::class, 'create']);
    });

    // Public routes
    Route::post('/login', [AuthController::class, 'login']);
});

// If not existing route is called
Route::any('{path}', function () {
    return response()->json([
        'message' => 'Route not found',
    ], 404);
})->where('path', '.*');
