<?php

use Src\Routing\Route;
use App\Controllers\Admin\ArticleController;
use App\Controllers\Admin\CommentController;
use App\Controllers\Admin\DashboardController;


Route::middleware('admin', function () {

    Route::get('/dashboard', DashboardController::class, 'index');

    // Post
    Route::get('/admin/mes-articles', ArticleController::class, 'index');
    Route::get('/admin/ajouter-article', ArticleController::class, 'create');
    Route::post('/admin/ajouter-article', ArticleController::class, 'store');
    Route::get('/admin/modifier-article/{slug}', ArticleController::class, 'edit');
    Route::post('/admin/modifier-article/{slug}', ArticleController::class, 'update');
    Route::post('/admin/supprimer-article', ArticleController::class, 'delete');

    // Comment
    Route::get('/admin/les-commentaires', CommentController::class, 'index');
    Route::get('/admin/valider-commentaire/{id}', CommentController::class, 'valide');
    Route::post('/admin/supprimer-commentaire', CommentController::class, 'delete');
});
