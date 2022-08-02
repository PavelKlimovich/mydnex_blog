<?php

namespace Database\Seeders;

use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;

class Seeder
{
    public function __construct() {
        new UserSeeder();
        new PostSeeder();
    }
}
