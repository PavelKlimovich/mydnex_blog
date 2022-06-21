<?php

namespace App\Controllers;

use App\Models\User;

class PageController extends Controller
{
    public function index()
    {
        $user = new User();
        $users = $user->all();
        return $this->render('index.twig',['users' => $users]);
    }
    
    public function about()
    {
        return $this->render('about.twig');
    }
}