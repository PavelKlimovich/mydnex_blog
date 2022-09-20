<?php

namespace Database\Seeders;

use Faker\Factory;
use Src\Helpers\Str;
use App\Models\Category;

class CategorySeeder
{
    public function __construct()
    {
        $this->run();
    }

    public function run()
    {   
        $category = new Category();
        $categories = ['News','PHP & Laravel','Technologies','Web'];

        for ($i=0; $i < 4; $i++) { 
            $category->create([
                'name'       => $categories[$i],
                'slug'       => Str::slugify($categories[$i]),
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
            ]);
        }
    }
}
