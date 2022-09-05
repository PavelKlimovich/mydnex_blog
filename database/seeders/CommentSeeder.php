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
        $comment = new Comment();
        $user = new User();
        $post = new Post();
        $users = $user->all()->get();
        $posts = $post->all()->get();

        for ($i=0; $i < 25; $i++) { 
            $comment->create([
                'message'    => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'user_id'    => $user->where('id','=',random_int(1, count($users)))->first()->id,
                'post_id'    => $post->where('id','=',random_int(1, count($posts)))->first()->id,
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
    }
}