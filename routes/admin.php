<?php

use Src\Routing\Route;
use App\Controllers\Admin\ArticleController;
use App\Controllers\Admin\DashboardController;


Route::middleware('admin', function(){

    Route::get('/dashboard', DashboardController::class, 'index');
    // Post
    Route::get('/admin/mes-articles', ArticleController::class, 'index');
    Route::get('/admin/ajouter-article', ArticleController::class, 'create');
    Route::post('/admin/ajouter-article', ArticleController::class, 'store');
    Route::get('/admin/modifier-article/{slug}', ArticleController::class, 'edit');
    Route::post('/admin/modifier-article/{slug}', ArticleController::class, 'update');
    Route::post('/adminv/supprimer-article', ArticleController::class, 'delete');

});