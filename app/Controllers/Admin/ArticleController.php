<?php

namespace App\Controllers\Admin;

use Config\App;
use App\Models\Post;
use Src\Helpers\Str;
use App\Models\Category;
use Src\Validator\Validator;
use App\Controllers\Controller;

class ArticleController extends Controller
{

    /**
     * Return article index page.
     *
     * @return mixed
     */
    public function index(): mixed
    { 
        $post = new Post();
        $posts = $post->all()->get();
        
        return $this->render('admin/article/index.twig', ['posts' => $posts]);
    }

    /**
     * Return article crete page.
     *
     * @return mixed
     */
    public function create(): mixed
    {
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('admin/article/create.twig', ['categories'=> $categories]);
    }

    /**
     * Store new Post.
     *
     * @return mixed
     */
    public function store(): mixed
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
            return $this->render('admin/article/create.twig', ['categories'=> $categories]);
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
        
        $app = new App();

        return $this->redirect($app->getAppUrl().'/admin/mes-articles');
    }

    /**
     * Return article edit page.
     *
     * @param string $slug
     * @return mixed
     */
    public function edit(string $slug): mixed
    {
        $post = new Post();
        $post = $post->where('slug', '=', $slug)->first();
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('admin/article/edit.twig', ['post' => $post, 'categories' => $categories]);  
    }


    /**
     * Update selected Post.
     *
     * @param string $slug
     * @return mixed
     */
    public function update(string $slug): mixed
    {
        Validator::create([
            "title" => 'Titre n\'est pas renseigné !',
            "category_id" => 'Categorie n\'est pas renseigné !',
            "description" => 'La description n\'est pas renseigné !',
            "content" => 'Le contenu n\'est pas renseigné !',
        ]);

        $post = new Post();
        $thisPost = $post->where('slug', '=', $slug)->first();
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
        $app = new App();

        return $this->redirect($app->getAppUrl().'/admin/mes-articles');
    }


    /**
     * Delete selected Post.
     *
     * @return mixed
     */
    public function delete(): mixed
    {
        $post = new Post();
        $post->delete($_POST['id']);
        $app = new App();

        return $this->redirect($app->getAppUrl().'/admin/mes-articles');
    }
}
