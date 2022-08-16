<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use Src\Helpers\Str;
use App\Models\Comment;

class CommentSeeder
{
    public function __construct()
    {
       $this->run();
    }

    public function run()
    {   
        $faker = Factory::create();
        $category = new Comment();
        $user = new User();
        $post = new Post();
        $users = $user->all();
        $posts = $post->all();

        for ($i=0; $i < 25; $i++) { 
            $category->create([
                'message'    => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'user_id'    => (int)$users[random_int(1, count($users))]['id'],
                'post_id'    => (int)$posts[random_int(1, count($posts))]['id'],
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
    }
}