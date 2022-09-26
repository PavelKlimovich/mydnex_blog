<?php 

namespace App\Middlewares;

use Config\App;

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
            $app = new App();
            header('Location:' .$app->getAppUrl().'/login');
            exit();
        }
    }
}
