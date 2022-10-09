<?php 

namespace App\Middlewares;

use Src\View\View;
use App\Models\User;
use Src\Session\Session;

class AuthMiddleware
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
        $this->redirectTo();
    }

    /**
     * Verify if user have access.
     *
     * @return void
     */
    public function redirectTo(): void
    {
        if (Session::get('auth')) {
            $user = $this->user->where('token', '=', Session::get('auth'))->first();

            if (!isset($user->token) || !Session::user_agent_matches()) {
                View::abord();
            }

        }else{
            header('Location:' .'/');
            View::abord();
        }
    }
}
