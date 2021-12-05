<?php

use App\Http\Controllers\RestApi\v1\ProjectController;
use App\Http\Controllers\RestApi\v1\RunTestController;
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

Route::get('/tests', [TestController::class, 'index']);
Route::get('/tests/{test_id}', [TestController::class, 'show']);
Route::get('/tests/search/{str}', [TestController::class, 'search']);
Route::get('/tests/run/all/{project_id}', [RunTestController::class, 'create']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project_id}', [ProjectController::class, 'show']);
Route::get('/projects/search/{str}', [ProjectController::class, 'search']);
