<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;

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
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::post('/logout', LogoutController::class)->name('logout');

Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
Route::get('/projects/create', [ProjectsController::class, 'create']);
Route::delete('/projects/{project}', [ProjectsController::class, 'destroy'])->name('projects.destroy');
Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
Route::get('/projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');
Route::patch('/projects/{project}', [ProjectsController::class, 'update'])->name('projects.update');

Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store'])->name('tasks.store');
Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update'])->name('tasks.update');

