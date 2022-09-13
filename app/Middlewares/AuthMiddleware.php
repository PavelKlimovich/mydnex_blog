<?php 

namespace App\Middlewares;

class AuthMiddleware
{
    public function __construct()
    {
        $this->redirectTo();
    }

    public function redirectTo()
    {
        if (!$_SESSION['auth']) {
            header('Location:' .$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
