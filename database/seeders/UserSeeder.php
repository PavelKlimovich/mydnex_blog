<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;

class UserSeeder
{
    public function __construct()
    {
        $this->run();
    }

    public function run()
    {   
        $faker = Factory::create();
        $user = new User();
        
        $user->create([
            'firstname'  => 'Pavel',
            'lastname'   => 'Klimovich',
            'email'      => 'pavelklimovich@hotmail.fr',
            'password'   => $user->createPassword('password'),
            'role'       => 'admin',
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);
    

        for ($i=0; $i < 5; $i++) { 
            $user->create([
                'firstname'  => $faker->firstName(),
                'lastname'   => $faker->lastName(),
                'email'      => $faker->email(),
                'password'   => $user->createPassword('password'),
                'role'       => 'user',
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }

    }
}
