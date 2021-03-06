<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeShowController;
use App\Http\Controllers\TestIndexController;
use App\Http\Controllers\DashboardIndexController;
use App\Http\Controllers\RestApi\v1\TestController;
use App\Http\Controllers\RestApi\v1\AllTestsController;
use App\Http\Controllers\RestApi\v1\ProjectHandleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', HomeShowController::class)->name('home');

Route::put('/verify/{project_id}', [ProjectController::class, 'update'])->middleware('auth')->name('verify-project');

Route::get('/dashboard', DashboardIndexController::class)->middleware(['auth'])->name('dashboard');

Route::post('/dashboard/add-project', [ProjectController::class, 'create'])->middleware('auth')->name('add-project');

Route::get('/dashboard/tests', TestIndexController::class)->middleware(['auth'])->name('tests');

Route::get('/dashboard/account', [AccountController::class, 'show'])->middleware(['auth'])->name('account');

Route::post('/dashboard/account/change-password', [AccountController::class, 'update'])->middleware(['auth']);

Route::get('/dashboard/{project:slug}', [ProjectController::class, 'show'])->middleware(['auth']);

Route::get('/admin', [AdminController::class, 'show'])->middleware('auth', 'admin')->name('admin-panel');

Route::get('/admin/load-tests', [AdminController::class, 'store'])->middleware('auth', 'admin');

Route::delete('/project/{project_id}/delete', [ProjectHandleController::class, 'destroy'])->middleware('auth');

Route::post('/tests/run/all', [AllTestsController::class, 'create'])->middleware('auth');

Route::post('/test/run/specific', [TestController::class, 'create'])->middleware('auth');

require __DIR__ . '/auth.php';
