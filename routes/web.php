<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'tampilRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('todo');
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/api/lists', [TodoController::class, 'index']);
    Route::post('/api/lists', [TodoController::class, 'storeList']);
    Route::post('/api/lists/{list}/tasks', [TodoController::class, 'storeTask']);
    Route::patch('/api/tasks/{task}', [TodoController::class, 'updateTask']);
    Route::delete('/api/tasks/{task}', [TodoController::class, 'destroyTask']);
});