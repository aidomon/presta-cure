<?php

use App\Http\Controllers\DashboardIndexController;
use App\Http\Controllers\HomeShowController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestIndexController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', DashboardIndexController::class)->middleware(['auth'])->name('dashboard');

Route::post('/dashboard/add-project', [ProjectController::class, 'create'])->middleware('auth')->name('add-project');

Route::get('/dashboard/tests', TestIndexController::class)->middleware(['auth'])->name('tests');

Route::get('/dashboard/{project:slug}', [ProjectController::class, 'show'])->middleware(['auth']);

require __DIR__ . '/auth.php';
