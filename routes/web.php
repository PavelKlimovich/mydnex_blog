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
Route::get('/articles', PageController::class, 'blog');
Route::get('/article', PageController::class, 'article');



/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

require __DIR__.'/admin.php';




Route::abord();
