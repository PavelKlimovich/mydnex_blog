<?php

namespace App\Controllers\Auth;

use Src\Auth\Auth;
use App\Models\User;
use Dotenv\Dotenv;
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

    public function auth()
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])  ) {
            $error = 'Email ou le mot de passe est vide ! ';
            return $this->render('auth/login.twig',['error' => $error]);
        }

        $user =  new User();
        $email = (string )$_POST['email'];
        $password = (string )$_POST['password'];
        $users = $user->where('email', '=', $email);
        
        if (empty($users)) {
            $error = 'Email ou le mot de passe est incorrect ! ';
            return $this->render('auth/login.twig',['error' => $error]);
        }

        $password = array_search($password, $users[0]);

        if (!$password ) {
            $error = 'Email ou le mot de passe est incorrect ! ';
            return $this->render('auth/login.twig',['error' => $error]);
        }
        
        
        $auth = new Auth($users[0]);

        session_start();
        $_SESSION['auth'] = $auth;
       
        if ($auth->isAdmin()) {
            return $this->dashboard();
        }

        return $this->redirect($_ENV['APP_URL'].'/blog');
        
    }

    public function dashboard()
    {
        return $this->redirect($_ENV['APP_URL'].'/dashboard');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        return $this->redirect($_ENV['APP_URL'].'/');
    }

}