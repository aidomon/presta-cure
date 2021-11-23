<?php

use App\Http\Controllers\RestApi\v1\TestController;
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

/* 
Obsah API

- get::/tests - get all available tests and their description
- get::/test - get just one particular test
- get::/run-all
- get::/run-one/{id}
*/


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/tests', [TestController::class, 'index']);
    Route::get('/tests/{test_id}', [TestController::class, 'show']);
    Route::get('/tests/search/{name}', [TestController::class, 'search']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return "$request->user()";
});

