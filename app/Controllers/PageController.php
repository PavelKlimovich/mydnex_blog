<?php

namespace App\Controllers;

use App\Models\User;
use Src\Database\DB;

class PageController extends Controller
{
    public function index()
    {
        return $this->render('index.twig');
    }
    
    public function blog()
    {
        return $this->render('blog.twig');
    }

    public function article()
    {
        return $this->render('article.twig');
    }
}