<?php

namespace App\Controllers;

use Src\View\View;
use App\Models\Post;
use Src\Mailer\Mail;
use App\Models\Comment;
use App\Models\Category;
use Src\Request\Request;
use Src\Validator\Validator;

class PageController
{
    private $post;
    private $category;

    public function __construct() 
    {
        $this->post = new Post();
        $this->category = new Category();
    }
    
    /**
     * Return index page.
     *
     * @return void
     */
    public function index(): void
    {
        $posts = $this->post->select(0, 3);
        
        View::get('index.twig', ['posts' => $posts]);
    }
    

    /**
     * Return blog page.
     *
     * @return void
     */
    public function blog(): void
    {
        $posts = $this->post->select(0, 5);
        $categories = $this->category->all()->get();

        View::get('blog.twig', ['posts' => $posts, 'categories' => $categories]);
    }

    /**
     * Return blog articl block.
     *
     * @param int|null $request
     * @return void
     */
    public function blogAjax(int $request = null): void
    {
        $posts = $this->post->select($request, $request + 5);
        
        View::get('data.twig', ['posts' => $posts]);
    }

    /**
     * Return category page.
     *
     * @param string $param
     * @return void
     */
    public function category($param): void
    {
        $category = $this->category->where('slug', '=', $param)->first();

        if (empty($category)) {
            View::abord();
        }
        
        $posts = $this->post->where('category_id', '=', $category->id)->get();
        $categories = $this->category->all()->get();

        View::get('blog.twig', ['posts' => $posts, 'categories' => $categories]);
    }

    /**
     * Return post page.
     *
     * @param string $param
     * @return void
     */
    public function article($param): void
    {
        if (!empty($param)) {
            $post = $this->post->where('slug', '=', $param)->first();

            if (empty($post)) { View::abord(); }
            
            $comment = new Comment();
            $comments = $comment->where('post_id', '=', $post->id)->get();

            View::get('article.twig', ['post' => $post, 'comments'=> $comments]);
        }

       View::abord();
    }

    /**
     * Send contact mail.
     *
     * @return void
     */
    public function contact(): void
    {
        Validator::create([
            "lastname" => 'Nom n\'est pas renseigné !',
            "firstname" => 'Prénom n\'est pas renseigné !',
            "email" => 'Email n\'est pas renseigné !',
            "message" => 'Message n\'est pas renseigné',
        ]);

        $request = new Request();
        $mail = new Mail("Mail de la part de : ".$request->post('firstname')." ".$request->post('lastname')."", $request->post('message'), null, $request->post('email'));
        $mail->send();

        View::redirect('/');
    }
}
