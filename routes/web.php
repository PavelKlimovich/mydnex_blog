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
Route::get('/article/{slug}', PageController::class, 'article');



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
