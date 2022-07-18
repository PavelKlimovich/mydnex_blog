<?php

use Src\Routing\Route;
use App\Controllers\Auth\AuthController;


Route::get('/login', AuthController::class, 'login');
Route::get('/register', AuthController::class, 'register');