<?php

namespace App\Controllers;

class PageController extends Controller
{
    public function index()
    {
        return $this->render('index.twig');
    }
    
    public function about()
    {
        return $this->render('about.twig');
    }
}