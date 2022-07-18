<?php

use Src\Routing\Route;
use App\Controllers\Admin\DashboardController;


Route::get('/dashboard', DashboardController::class, 'index');