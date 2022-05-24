<?php

namespace App\Controllers;

use Src\View\View;


class PageController
{
    public static function index()
    {
        return View::view('index.twig');
    }
}