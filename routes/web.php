<?php

use Src\Routing\Route;
use App\Controllers\PageController;


Route::get('/', PageController::index());
