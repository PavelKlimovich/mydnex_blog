<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use Src\Helpers\Str;
use App\Models\Category;

class PostSeeder
{
    public function __construct()
    {
       $this->run();
    }

    public function run()
    {   
        $faker = Factory::create();
        $post  = new Post();
        $category = new Category();
        $categories = $category->all()->get();
    
        for ($i=0; $i < 15; $i++) { 
            $title = $faker->sentence($nbWords = 6, $variableNbWords = true);

            $post->create([
                'title'         => $title,
                'slug'          => Str::slugify($title),
                'description'   => $faker->text($maxNbChars = 200),
                'content'       => $faker->paragraph(5),
                'image'         => $faker->imageUrl(640, 480, 'animals', true),
                'user_id'       => 1,
                'category_id'   => $categories->where('id','=',random_int(1, count($categories)))->id,
                'created_at'    => date("Y-m-d"),
                'updated_at'    => date("Y-m-d"),
            ]);
        }

    }
}