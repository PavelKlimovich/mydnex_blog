<?php

namespace Database\Seeders;

use App\Models\User;

class UserSeeder
{
    public function __construct()
    {
       $this->run();
    }

    public function run()
    {   
        $user = new User();
        
        $user->insert([
            'firstname'  => 'Pavel',
            'lastname'   => 'Klimovich',
            'email'      => 'pavelklimovich@hotmail.fr',
            'password'   => 'password',
            'verified'   => 0,
            'role'       => 'admin',
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);
    }
}
