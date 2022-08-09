<?php

use Src\Routing\Route;
use App\Controllers\Auth\AuthController;


Route::get('/login', AuthController::class, 'login');
Route::post('/login', AuthController::class, 'auth');
Route::get('/logout', AuthController::class, 'logout');
Route::get('/register', AuthController::class, 'register');