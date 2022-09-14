<?php 

namespace App\Middlewares;

class AdminMiddleware
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
        if (!$_SESSION['admin']) {
            header('Location:' .$_ENV['APP_URL'].'/login');
            exit();
        }
    }
}
