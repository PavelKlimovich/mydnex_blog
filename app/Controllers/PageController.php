<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use Src\Mailer\Mail;
use Src\Routing\Route;
use App\Models\Comment;
use PhpParser\Node\Expr\AssignOp\Mod;

class PageController extends Controller
{
    public function index()
    {
        session_start();
        $auth = false;

        if (isset($_SESSION['auth'])) {
            $auth = true;
        }

        $post = new Post();
        $posts = $post->first(0,3);
        
        return $this->render('index.twig',['posts' => $posts,'auth' => $auth]);
    }
    
    public function blog()
    {
        session_start();
        $auth = false;

        if (isset($_SESSION['auth'])) {
            $auth = true;
        }

        $post = new Post();
        $posts = $post->first(0,5);
        $category = new Category();
        $categories = $category->all();

        return $this->render('blog.twig',['posts' => $posts,'auth' => $auth,'categories' => $categories]);
    }

    public function category($param)
    {
        session_start();
        $auth = false;

        if (isset($_SESSION['auth'])) {
            $auth = true;
        }

        $post = new Post();
        $category = new Category();
        $category = $category->where('slug','=', $param);
        $posts = $post->where('category_id','=', $category[0]['id']);
        $category = new Category();
        $categories = $category->all();

        return $this->render('blog.twig',['posts' => $posts,'auth' => $auth,'categories' => $categories]);
    }

    public function article($param)
    {
        session_start();
        $auth = false;

        if (isset($_SESSION['auth'])) {
            $auth = true;
        }

        if (!empty($param)) {
            $post = new Post();
            $comment = new Comment();
            $post = $post->where('slug','=', $param);
            $comments = $comment->where('post_id','=',$post[0]['id']);

            if ($post){
                return $this->render('article.twig',['post' => $post[0], 'auth' => $auth, 'comments'=> $comments]);
            }
        }

        Route::abord();
    }

    public function contact()
    {
        if (empty($_POST['lastname']) ) {
            $error = 'Nom n\'est pas renseigné !';
            return $this->render('index.twig',['error' => $error]);
        }
        if (empty($_POST['firstname']) ) {
            $error = 'Prénom n\'est pas renseigné!';
            return $this->render('index.twig',['error' => $error]);
        }
        if (empty($_POST['email']) ) {
            $error = 'Email n\'est pas renseigné !';
            return $this->render('index.twig',['error' => $error]);
        }

        if (empty($_POST['message']) ) {
            $error = 'Message n\'est pas renseigné !';
            return $this->render('index.twig',['error' => $error]);
        }

        $mail = new Mail("pavelklimovich@hotmail.fr", "Essai de PHP Mail", "PHP Mail fonctionne parfaitement");
        $mail->send();

        return $this->redirect($_ENV['APP_URL'].'/');
    }
}