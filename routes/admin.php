<?php

use Src\Routing\Route;
use App\Controllers\Admin\ArticleController;
use App\Controllers\Admin\DashboardController;


Route::get('/dashboard', DashboardController::class, 'index');

Route::get('/admin/mes-rticles', ArticleController::class, 'index');
Route::get('/admin/ajouter-aticle', ArticleController::class, 'create');
Route::post('/admin/ajouter-aticle', ArticleController::class, 'store');
Route::get('/admin/modifier-aricle/{slug}', ArticleController::class, 'edit');
Route::post('/admin/modifier-aricle/{slug}', ArticleController::class, 'update');
    
