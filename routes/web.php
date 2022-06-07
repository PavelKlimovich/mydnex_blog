<?php

use Src\Routing\Route;
use App\Controllers\PageController;

Route::get('/', PageController::class, 'index');
Route::get('/about', PageController::class, 'about');

Route::abord();