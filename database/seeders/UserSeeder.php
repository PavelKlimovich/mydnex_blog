<?php

namespace Database\Seeders;

use App\Models\User;


class UserSeeder
{
    public string $table = 'users';

    public function __construct()
    {
       $this->run();
    }

    public function run()
    {   
        $user = new User();
        $user->insert([
            'name'  => 'Pavel Klimovich',
            'creat' => '2',
            'test'  => '2',
        ]);
    }
}
