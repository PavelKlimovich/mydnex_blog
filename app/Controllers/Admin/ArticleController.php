<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use Src\Helpers\Str;
use App\Models\Category;
use App\Controllers\Controller;
use Src\Validator\Validator;

class ArticleController extends Controller
{

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    { 
        $post = new Post();
        $posts = $post->all()->get();
        
        return $this->render('admin/article/index.twig',['posts' => $posts]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('admin/article/create.twig',['categories'=> $categories]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function store()
    {
        $category = new Category();
        $categories = $category->all()->get();

        Validator::create([
            "title" => 'Titre n\'est pas renseigné !',
            "category_id" => 'Categorie n\'est pas renseigné !',
            "description" => 'La description n\'est pas renseigné !',
            "content" => 'Le contenu n\'est pas renseigné !',
        ]);

        if (empty($_FILES['image']) ) {
            $_SESSION['error'] = 'Image n\'est pas renseigné !' ;    
            $_SESSION['error_delay'] = '1';
            return $this->render('admin/article/create.twig',['categories'=> $categories]);
        }

        $path = $_FILES["image"]["tmp_name"];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        $post = new Post();

        $post->create([
            'title'         => $_POST['title'],
            'slug'          => Str::slugify($_POST['title']),
            'description'   => $_POST['description'],
            'content'       => $_POST['content'],
            'image'         => $base64,
            'user_id'       => 1,
            'category_id'   => (int)$_POST['category_id'],
            'created_at'    => date("Y-m-d"),
            'updated_at'    => date("Y-m-d"),

        ]);

        return $this->redirect($_ENV['APP_URL'].'/admin/mes-articles');
    }

    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     */
    public function edit($slug)
    {
        $post = new Post();
        $post = $post->where('slug','=', $slug)->first();
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('admin/article/edit.twig', ['post' => $post, 'categories' => $categories]);  
    }


    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     */
    public function update($slug)
    {
        Validator::create([
            "title" => 'Titre n\'est pas renseigné !',
            "category_id" => 'Categorie n\'est pas renseigné !',
            "description" => 'La description n\'est pas renseigné !',
            "content" => 'Le contenu n\'est pas renseigné !',
        ]);

        $post = new Post();
        $thisPost = $post->where('slug','=', $slug)->first();
        $base64 = $thisPost->image;

        if (!empty($_FILES['image']["tmp_name"]) ) {
            $path = $_FILES["image"]["tmp_name"];
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        
        $post->update($thisPost->id, [
            'title'         => $_POST['title'],
            'slug'          => Str::slugify($_POST['title']),
            'description'   => $_POST['description'],
            'content'       => $_POST['content'],
            'image'         => $base64,
            'user_id'       => 1,
            'category_id'   => (int)$_POST['category_id'],
            'created_at'    => date("Y-m-d"),
            'updated_at'    => date("Y-m-d"),
        ]);

        return $this->redirect($_ENV['APP_URL'].'/admin/mes-articles');
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function delete()
    {
        $post = new Post();
        $post->delete($_POST['id']);

        return $this->redirect($_ENV['APP_URL'].'/admin/mes-articles');
    }
}