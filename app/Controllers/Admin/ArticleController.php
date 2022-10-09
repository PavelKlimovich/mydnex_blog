<?php

namespace App\Controllers\Admin;

use Src\View\View;
use App\Models\Post;
use App\Models\User;
use Src\Helpers\Str;
use App\Models\Category;
use Src\Request\Request;
use Src\Session\Session;
use Src\Validator\Validator;

class ArticleController
{
    private $post;
    private $category;
    private $request;

    public function __construct() 
    {
        $this->post = new Post();
        $this->category = new Category();;
        $this->request = new Request();
    }

    /**
     * Return article index page.
     *
     * @return void
     */
    public function index(): void
    { 
        $posts = $this->post->all()->get();
        
        View::get('admin/article/index.twig', ['posts' => $posts]);
    }

    /**
     * Return article crete page.
     *
     * @return void
     */
    public function create(): void
    {
        $user = new User();
        $categories = $this->category->all()->get();
        $authors = $user->where('role', '=', 'admin')->get();

        View::get('admin/article/create.twig', ['categories'=> $categories, 'authors' => $authors]);
    }

    /**
     * Store new Post.
     *
     * @return void
     */
    public function store(): void
    {
        Validator::create([
            "title" => 'Titre n\'est pas renseigné !',
            "category_id" => 'Categorie n\'est pas renseigné !',
            "description" => 'La description n\'est pas renseigné !',
            "content" => 'Le contenu n\'est pas renseigné !',
            "author" => 'L\'author n\'est pas renseigné !',
        ]);

        if (!isset($_FILES['image']) || empty($_FILES['image']["tmp_name"]) ) {
            Session::error('Image n\'est pas renseigné !');
            View::redirect('/admin/ajouter-article');
        }

        $path = $_FILES["image"]["tmp_name"];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->post->create([
            'title'         => $this->request->post('title'),
            'slug'          => Str::slugify($this->request->post('title')),
            'description'   => $this->request->post('description'),
            'content'       => $this->request->post('content'),
            'image'         => $base64,
            'user_id'       => (int)$this->request->post('author'),
            'category_id'   => (int)$this->request->post('category_id'),
            'created_at'    => date("Y-m-d"),
            'updated_at'    => date("Y-m-d"),
        ]);

        Session::success('Article à bien été crée !');

        View::redirect('/admin/mes-articles');
    }

    /**
     * Return article edit page.
     *
     * @param string $slug
     * @return void
     */
    public function edit(string $slug): void
    {
        $post = $this->post->where('slug', '=', $slug)->first();
        $user = new User();
        $categories = $this->category->all()->get();
        $authors = $user->where('role', '=', 'admin')->get();

        View::get('admin/article/edit.twig', ['post' => $post, 'categories' => $categories, 'authors' => $authors]);  
    }


    /**
     * Update selected Post.
     *
     * @param string $slug
     * @return void
     */
    public function update(string $slug): void
    {
        Validator::create([
            "title" => 'Titre n\'est pas renseigné !',
            "category_id" => 'Categorie n\'est pas renseigné !',
            "description" => 'La description n\'est pas renseigné !',
            "content" => 'Le contenu n\'est pas renseigné !',
            "author" => 'L\'author n\'est pas renseigné !',
        ]);

        $post = $this->post->where('slug', '=', $slug)->first();
        $base64 = $post->image;

        if (!empty($_FILES['image']["tmp_name"]) ) {
            $path = $_FILES["image"]["tmp_name"];
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        
        $post->update($post->id,[
            'title'         => $this->request->post('title'),
            'slug'          => Str::slugify($this->request->post('title')),
            'description'   => $this->request->post('description'),
            'content'       => $this->request->post('content'),
            'image'         => $base64,
            'user_id'       => (int)$this->request->post('author'),
            'category_id'   => (int)$this->request->post('category_id'),
            'updated_at'    => date("Y-m-d"),
        ]);

        Session::success('Article à bien été modifié!');

        View::redirect('/admin/mes-articles');
    }


    /**
     * Delete selected Post.
     *
     * @return void
     */
    public function delete(): void
    {
        $this->post->delete($this->request->post('id'));
        Session::success('Article à bien été supprimé !');
        
        View::redirect('/admin/mes-articles');
    }
}
