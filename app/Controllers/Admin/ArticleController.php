<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use Src\Helpers\Str;
use App\Models\Category;
use App\Controllers\Controller;

class ArticleController extends Controller
{

    public function index()
    {
        session_start();

        if ($_SESSION['auth']->role !== 'admin') {
            return $this->redirect($_ENV['APP_URL'].'/login');
        }


        $post = new Post();
        $posts = $post->all();
        
        return $this->render('admin/article/index.twig',['posts' => $posts]);
        
    }

    public function create()
    {
        session_start();

        if ($_SESSION['auth']->role !== 'admin') {
            return $this->redirect($_ENV['APP_URL'].'/login');
        }

        $category = new Category();
        $categories = $category->all();


        return $this->render('admin/article/create.twig',['categories'=> $categories]);
        
    }


    public function store()
    {
        session_start();

        if ($_SESSION['auth']->role !== 'admin') {
            return $this->redirect($_ENV['APP_URL'].'/login');
        }

        $category = new Category();
        $categories = $category->all();

        if (empty($_POST['title']) ) {
            $error = 'Titre n\'est pas renseigné !';
            return $this->render('admin/article/create.twig',['categories'=> $categories,'error' => $error]);
        }
        if (empty($_POST['category_id']) ) {
            $error = 'Categorie n\'est pas renseigné!';
            return $this->render('admin/article/create.twig',['categories'=> $categories,'error' => $error]);
        }
        if (empty($_POST['description']) ) {
            $error = 'La description n\'est pas renseigné !';
            return $this->render('admin/article/create.twig',['categories'=> $categories,'error' => $error]);
        }

        if (empty($_POST['content']) ) {
            $error = 'Le contenu n\'est pas renseigné !';
            return $this->render('admin/article/create.twig',['categories'=> $categories,'error' => $error]);
        }
        if (empty($_FILES['image']) ) {
            $error = 'Image n\'est pas renseigné !';
            return $this->render('admin/article/create.twig',['categories'=> $categories,'error' => $error]);
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

        return $this->redirect($_ENV['APP_URL'].'/admin/mes-rticles');
        
    }

    public function edit($slug)
    {
        session_start();

        if ($_SESSION['auth']->role !== 'admin') {
            return $this->redirect($_ENV['APP_URL'].'/login');
        }


        return $this->render('admin/article/edit.twig');
        
    }

    public function update()
    {
        session_start();

        if ($_SESSION['auth']->role !== 'admin') {
            return $this->redirect($_ENV['APP_URL'].'/login');
        }


        return $this->redirect($_ENV['APP_URL'].'/admin/mes-rticles');
        
    }

}