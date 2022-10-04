<?php

namespace App\Controllers\Admin;

use Config\App;
use App\Models\Post;
use App\Models\User;
use Src\Helpers\Str;
use App\Models\Category;
use Src\Request\Request;
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
        
        return $this->view('admin/article/index.twig', ['posts' => $posts]);
    }

    /**
     * Return article crete page.
     *
     * @return mixed
     */
    public function create(): mixed
    {
        $category = new Category();
        $user = new User();
        $categories = $category->all()->get();
        $authors = $user->where('role', '=', 'admin')->get();

        return $this->view('admin/article/create.twig', ['categories'=> $categories, 'authors' => $authors]);
    }

    /**
     * Store new Post.
     *
     * @return mixed
     */
    public function store(): mixed
    {
        $request = new Request();
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
            return $this->view('admin/article/create.twig', ['categories'=> $categories]);
        }

        $path = $_FILES["image"]["tmp_name"];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        $post = new Post();

        $post->create([
            'title'         => $request->title,
            'slug'          => Str::slugify($request->title),
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $base64,
            'user_id'       => $request->author,
            'category_id'   => (int)$request->category_id,
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
        $user = new User();
        $category = new Category();
        $categories = $category->all()->get();
        $authors = $user->where('role', '=', 'admin')->get();

        return $this->view('admin/article/edit.twig', ['post' => $post, 'categories' => $categories, 'authors' => $authors]);  
    }


    /**
     * Update selected Post.
     *
     * @param string $slug
     * @return mixed
     */
    public function update(string $slug): mixed
    {
        $request = new Request();

        Validator::create([
            "title" => 'Titre n\'est pas renseigné !',
            "category_id" => 'Categorie n\'est pas renseigné !',
            "description" => 'La description n\'est pas renseigné !',
            "content" => 'Le contenu n\'est pas renseigné !',
            "author" => 'L\'author n\'est pas renseigné !',
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
            'title'         => $request->title,
            'slug'          => Str::slugify($request->title),
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $base64,
            'user_id'       => $request->author,
            'category_id'   => (int)$request->category_id,
            'created_at'    => $thisPost->created_at,
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
        $request = new Request();
        $post->delete($request->id);
        $app = new App();

        return $this->redirect($app->getAppUrl().'/admin/mes-articles');
    }
}
