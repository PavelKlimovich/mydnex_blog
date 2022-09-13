<?php

namespace App\Controllers\Auth;

use Dotenv\Dotenv;
use Src\Auth\Auth;
use App\Models\User;
use Src\Validator\Validator;
use App\Controllers\Controller;

class AuthController extends Controller
{

    /**
     * Return login page.
     *
     * @return mixed
     */
    public function login(): mixed
    {
        return $this->render('auth/login.twig');
    }

    /**
     * Return register page.
     *
     * @return mixed
     */
    public function register(): mixed
    {
        return $this->render('auth/register.twig');
    }

    /**
     * Verifed auth.
     *
     * @return mixed
     */
    public function auth(): mixed
    {
        Validator::create([
                "email" => 'Email ou le mot de passe est vide !',
                "password" => 'Mot de passe n\'est pas renseigné !',
            ]);

        $user =  new User();
        $email = (string)$_POST['email'];
        $password = (string)$_POST['password'];
        $user = $user->where('email', '=', $email)->first();
        
        if (empty($user)) {
            $_SESSION['error'] = 'Email ou le mot de passe est incorrect !' ;    
            $_SESSION['error_delay'] = '1';

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        if ($user->password !== $password ) {
            $_SESSION['error'] = 'Email ou le mot de passe est incorrect !' ;    
            $_SESSION['error_delay'] = '1';

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
        $_SESSION['auth'] = true;
        $_SESSION['auth_id'] = $user->id;

        if ($user->isAdmin()) {
            $_SESSION['admin'] = true;
            return $this->dashboard();
        }

        return $this->redirect($_ENV['APP_URL'].'/blog');
    }

    /**
     * Return dashboard page.
     *
     * @return mixed
     */
    public function dashboard(): mixed
    {
        return $this->redirect($_ENV['APP_URL'].'/dashboard');
    }

    /**
     * Logout auth.
     *
     * @return mixed
     */
    public function logout(): mixed
    {
        session_destroy();
        return $this->redirect($_ENV['APP_URL'].'/');
    }

    /**
     * Store new user.
     *
     * @return mixed
     */
    public function store(): mixed
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

        $userObject  = new User();
        $email = (string)$_POST['email'];
        $user = $userObject->where('email', '=', $email)->first();

        if (!empty($user)) {
            $_SESSION['error'] = 'Utilisateur avec ce mail exist deja !' ;    
            $_SESSION['error_delay'] = '1';
            
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        $userObject->create([
            'firstname'  => (string)$_POST['firstname'],
            'lastname'   => (string)$_POST['lastname'],
            'email'      => (string)$_POST['email'],
            'password'   => (string)$_POST['password'],
            'verified'   => 0,
            'role'       => 'user',
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);

        $_SESSION['auth'] = true;
       
        if ($user->isAdmin()) {
            $_SESSION['admin'] = true;
            return $this->dashboard();
        }
       
        return $this->redirect($_ENV['APP_URL'].'/blog');
    }

}
