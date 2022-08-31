<?php

namespace App\Controllers\Auth;

use Dotenv\Dotenv;
use Src\Auth\Auth;
use App\Models\User;
use Src\Validator\Validator;
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
        Validator::create([
            "email" => 'Email ou le mot de passe est vide !',
            "password" => 'Mot de passe n\'est pas renseigné !',
        ]);

        $user =  new User();
        $email = (string)$_POST['email'];
        $password = (string)$_POST['password'];
        $users = $user->where('email', '=', $email);
        
        if (empty($users)) {
            $_SESSION['error'] = 'Email ou le mot de passe est incorrect !' ;    
            $_SESSION['error_delay'] = '1';

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        $password = array_search($password, $users[0]);

        if (!$password ) {
            $_SESSION['error'] = 'Email ou le mot de passe est incorrect !' ;    
            $_SESSION['error_delay'] = '1';

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
        $auth = new Auth($users[0]);
        $_SESSION['auth'] = true;
        if ($auth->isAdmin()) {
            $_SESSION['admin'] = true;
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
        session_destroy();
        return $this->redirect($_ENV['APP_URL'].'/');
    }

    public function store()
    {
        Validator::create([
            "lastname" => 'Nom n\'est pas renseigné !',
            "firstname" => 'Prénom n\'est pas renseigné !',
            "email" => 'Email n\'est pas renseigné !',
            "password" => 'Mot de passe n\'est pas renseigné !',
            "password_confirmation" => 'Mot de passe n\'est pas renseigné !',
        ]);

        if ($_POST['password'] !== $_POST['password_confirmation']) {
            $_SESSION['error'] = 'Mot de passe n\'est pas renseigné !' ;    
            $_SESSION['error_delay'] = '1';

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        if (!isset($_POST['rgpd']) || ($_POST['rgpd'] == false)) {
            $_SESSION['error'] = 'Vous devez accepter les mentions légales !' ;    
            $_SESSION['error_delay'] = '1';

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        $user  = new User();
        $email = (string)$_POST['email'];
        $users = $user->where('email', '=', $email);

        if (!empty($users)) {
            $_SESSION['error'] = 'Utilisateur avec ce mail exist deja !' ;    
            $_SESSION['error_delay'] = '1';
            
            return $this->redirect($_SERVER['HTTP_REFERER']);
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
        $_SESSION['auth'] = true;
       
        if ($auth->isAdmin()) {
            $_SESSION['admin'] = true;
            return $this->dashboard();
        }
       
        return $this->redirect($_ENV['APP_URL'].'/blog');
    }

}