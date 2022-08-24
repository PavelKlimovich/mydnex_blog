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
        if (empty($_POST['email']) || empty($_POST['password'])  ) {
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

    public function store()
    {
        if (empty($_POST['lastname']) ) {
            $error = 'Nom n\'est pas renseigné !';
            return $this->render('auth/register.twig',['error' => $error]);
        }
        if (empty($_POST['firstname']) ) {
            $error = 'Prénom n\'est pas renseigné!';
            return $this->render('auth/register.twig',['error' => $error]);
        }
        if (empty($_POST['email']) ) {
            $error = 'Email n\'est pas renseigné !';
            return $this->render('auth/register.twig',['error' => $error]);
        }
        if (empty($_POST['password']) || empty($_POST['password_confirmation'])) {
            $error = 'Mot de passe n\'est pas renseigné !';
            return $this->render('auth/register.twig',['error' => $error]);
        }
        if ($_POST['password'] !== $_POST['password_confirmation']) {
            $error = 'Mot de passe n\'est pas renseigné !';
            return $this->render('auth/register.twig',['error' => $error]);
        }
        if (!isset($_POST['rgpd']) || ($_POST['rgpd'] == false)) {
            $error = 'Vous devez accepter les mentions légales !';
            return $this->render('auth/register.twig',['error' => $error]);
        }

        $user  = new User();
        $email = (string)$_POST['email'];
        $users = $user->where('email', '=', $email);

        if (!empty($users)) {
            $error = 'Utilisateur avec ce mail exist deja ! ';
            return $this->render('auth/register.twig',['error' => $error]);
        }

        $user->create([
            'firstname'  => (string)$_POST['firstname'],
            'lastname'   => (string)$_POST['lastname'],
            'email'      => (string)$_POST['email'],
            'password'   => (string)$_POST['password'],
            'verified'   => 0,
            'role'       => 'user',
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);

        $users = $user->where('email', '=', $email);
        $auth = new Auth($users[0]);

        session_start();
        $_SESSION['auth'] = $auth;
       
        return $this->redirect($_ENV['APP_URL'].'/blog');
    }

}