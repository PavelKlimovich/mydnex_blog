<?php

namespace App\Controllers;

use App\Models\Post;
use Src\Routing\Route;

class PageController extends Controller
{
    public function index()
    {
        return $this->render('index.twig');
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

        return $this->render('blog.twig',['posts' => $posts,'auth' => $auth]);
    }

    public function article($param)
    {
        if (!empty($param)) {
            $post = new Post();
            $post = $post->where('slug','=', $param);

            if ($post){
                return $this->render('article.twig',['post' => $post[0]]);
            }
        }

        Route::abord();
    }

}