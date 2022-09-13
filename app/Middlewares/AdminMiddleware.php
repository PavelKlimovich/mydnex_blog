<?php 

namespace App\Middlewares;

class AdminMiddleware
{
    public function __construct()
    {
        $this->redirectTo();
    }

    public function redirectTo()
    {
        if (!$_SESSION['admin']) {
            header('Location:' .$_ENV['APP_URL'].'/login');
            exit();
        }
    }
}
