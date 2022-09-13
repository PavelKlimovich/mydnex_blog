<?php

namespace Database\Seeders;

use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CategorySeeder;

class Seeder
{
    public function __construct()
    {
        new UserSeeder();
        new CategorySeeder();
        new PostSeeder();
        new CommentSeeder();
    }
}
