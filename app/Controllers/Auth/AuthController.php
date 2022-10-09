<?php

namespace App\Controllers\Auth;

use Src\View\View;
use App\Models\User;
use Src\Helpers\Str;
use Src\Request\Request;
use Src\Session\Session;
use Src\Validator\Validator;

class AuthController
{
    private $user;
    private $request;

    public function __construct() 
    {
        $this->user = new User();
        $this->request = new Request();
    }

    /**
     * Return login page.
     *
     * @return void
     */
    public function login(): void
    {
        View::get('auth/login.twig');
    }

    /**
     * Return register page.
     *
     * @return void
     */
    public function register(): void
    {
        View::get('auth/register.twig');
    }

    /**
     * Verifed auth.
     *
     * @return void
     */
    public function auth(): void
    {
        Validator::create([
            "email" => 'Email ou le mot de passe est vide !',
            "password" => 'Mot de passe n\'est pas renseigné !',
        ]);

        $user = $this->user->where('email', '=', $this->request->email)->first();
        
        if (empty($user) || !password_verify($this->request->password, $user->password)) {
            Session::error('Email ou le mot de passe est incorrect !' );
            View::redirect($_SERVER['HTTP_REFERER']);
        }

        $token = Str::token();
        $this->user->update($user->id,['token' => $token]);
        Session::addAuth($token);

        if ($user->isAdmin()) {
            Session::add('admin', 'true');
            View::redirect('/dashboard');
        }

        View::redirect('/blog');
    }

    /**
     * Logout auth.
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        View::redirect('/');
    }

    /**
     * Store new user.
     *
     * @return void
     */
    public function store(): void
    {
        Validator::create([
            "lastname" => 'Nom n\'est pas renseigné !',
            "firstname" => 'Prénom n\'est pas renseigné !',
            "email" => 'Email n\'est pas renseigné !',
            "password" => 'Mot de passe n\'est pas renseigné !',
            "password_confirmation" => 'Mot de passe n\'est pas renseigné !',
        ]);

        if ($this->request->post('password') !== $this->request->post('password_confirmation')) {
            Session::error('Mot de passe n\'est pas renseigné !');

            View::redirect($_SERVER['HTTP_REFERER']);
        }

        $user = $this->user->where('email', '=', $this->request->post('email'))->first();

        if (!empty($user)) {
            Session::error('Utilisateur avec ce mail exist deja !');
            
            View::redirect($_SERVER['HTTP_REFERER']);
        }

        $token = Str::token();
        $this->user->create([
            'firstname'  => $this->request->post('firstname'),
            'lastname'   => $this->request->post('lastname'),
            'email'      => $this->request->post('email'),
            'password'   => $this->user->createPassword($this->request->post('password')),
            'token'      => $token,
            'role'       => 'user',
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);

        Session::addAuth($token);

        View::redirect('/blog');
    }
}
