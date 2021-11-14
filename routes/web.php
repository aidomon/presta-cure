<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('layouts.projects', [
        'projects' => Auth::user()->projects
    ]);
})->middleware(['auth'])->name('dashboard');

Route::post('/dashboard/add-project', [ProjectController::class, 'create'])
                ->middleware('auth')
                ->name('add-project');

Route::get('/dashboard/project', function () {
    return view('layouts.project');
})->middleware(['auth']);

require __DIR__.'/auth.php';
