<?php

use Illuminate\Support\Facades\Route;

Route::get('/halo', function () {
    return 'dari backend';
});

use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'tampilRegister']);
Route::post('/register', [AuthController::class, 'register']);