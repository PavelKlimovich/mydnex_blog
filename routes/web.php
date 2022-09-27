<?php

use Src\Routing\Route;
use App\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', PageController::class, 'index');
Route::post('/', PageController::class, 'contact');
Route::get('/blog', PageController::class, 'blog');
Route::get('/get-post/{request}', PageController::class, 'blogAjax');
Route::get('/blog/{slug}', PageController::class, 'category');
Route::get('/article/{slug}', PageController::class, 'article');



/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
*/

require_once __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

require_once __DIR__.'/admin.php';




Route::abord();
