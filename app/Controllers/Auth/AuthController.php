<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return $this->render('auth/login.twig');
    }

    public function register()
    {
        return $this->render('auth/register.twig');
    }

}