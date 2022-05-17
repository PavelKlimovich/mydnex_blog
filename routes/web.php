<?php

use Src\Routing\Route;

Route::get('/', '../app/Views/index.php');



//$request = $_SERVER['REQUEST_URI'];

//switch ($request) {
//    case '/' :
//        require '../app/Views/index.php';
//        break;
//    default:
//        http_response_code(404);
//        require '../app/Views/errors/404.php';
//        break;
//}