<?php

namespace App\Controllers;

use App\Models\Post;
use Src\Mailer\Mail;
use Src\Routing\Route;
use App\Models\Comment;
use App\Models\Category;
use Src\Validator\Validator;
use PhpParser\Node\Expr\AssignOp\Mod;

class PageController extends Controller
{
    public function index()
    {
        $post = new Post();
        $posts = $post->select(0, 3);
        
        return $this->render('index.twig', ['posts' => $posts]);
    }
    
    public function blog()
    {
        $post = new Post();
        $posts = $post->select(0, 5);
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('blog.twig', ['posts' => $posts, 'categories' => $categories]);
    }

    public function blogAjax($request = null)
    {
        $post = new Post();
        $posts = $post->select($request, $request + 5);
        
        return $this->render('data.twig', ['posts' => $posts]);
    }

    public function category($param)
    {
        $post = new Post();
        $category = new Category();
        $category = $category->where('slug', '=', $param)->first();
        if (empty($category)) {
            Route::abord();
        }
        $posts = $post->where('category_id', '=', $category->id)->get();
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('blog.twig', ['posts' => $posts, 'categories' => $categories]);
    }

    public function article($param)
    {
        if (!empty($param)) {
            $post = new Post();
            $comment = new Comment();
            $post = $post->where('slug', '=', $param)->first();

            if (empty($post)) {
                Route::abord();
            }

            $comments = $comment->where('post_id', '=', $post->id)->get();

            return $this->render('article.twig', ['post' => $post, 'comments'=> $comments]);
        }

        Route::abord();
    }

    public function contact()
    {
        Validator::create(
            [
            "lastname" => 'Nom n\'est pas renseigné !',
            "firstname" => 'Prénom n\'est pas renseigné !',
            "email" => 'Email n\'est pas renseigné !',
            "message" => 'Message n\'est pas renseigné',
            ]
        );

        $mail = new Mail("pavelklimovich@hotmail.fr", "Essai de PHP Mail", "PHP Mail fonctionne parfaitement");
        $mail->send();

        return $this->redirect($_ENV['APP_URL'].'/');
    }
}
