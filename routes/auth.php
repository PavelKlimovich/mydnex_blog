<?php

use Src\Routing\Route;
use App\Controllers\Auth\AuthController;
use App\Controllers\Admin\CommentController;


Route::get('/login', AuthController::class, 'login');
Route::post('/login', AuthController::class, 'auth');
Route::get('/logout', AuthController::class, 'logout');
Route::get('/register', AuthController::class, 'register');
Route::post('/register', AuthController::class, 'store');


Route::middleware('auth', function () {
        Route::post('/store-comment', CommentController::class, 'store');
    }
);
