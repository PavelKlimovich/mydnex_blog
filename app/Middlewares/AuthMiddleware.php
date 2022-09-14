<?php 

namespace App\Middlewares;

class AuthMiddleware
{
    public function __construct()
    {
        $this->redirectTo();
    }

    /**
     * Verify if user have access.
     *
     * @return void
     */
    public function redirectTo(): void
    {
        if (!$_SESSION['auth']) {
            header('Location:' .$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
