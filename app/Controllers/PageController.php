<?php

namespace App\Controllers;

use App\Models\Post;
use Src\Mailer\Mail;
use Src\Routing\Route;
use App\Models\Comment;
use App\Models\Category;
use Src\Validator\Validator;

class PageController extends Controller
{

    /**
     * Return index page.
     *
     * @return mixed
     */
    public function index(): mixed
    {
        $post = new Post();
        $posts = $post->select(0, 3);
        
        return $this->render('index.twig', ['posts' => $posts]);
    }
    

    /**
     * Return blog page.
     *
     * @return mixed
     */
    public function blog(): mixed
    {
        $post = new Post();
        $posts = $post->select(0, 5);
        $category = new Category();
        $categories = $category->all()->get();

        return $this->render('blog.twig', ['posts' => $posts, 'categories' => $categories]);
    }

    /**
     * Return blog articl block.
     *
     * @param int|null $request
     * @return mixed
     */
    public function blogAjax(int $request = null): mixed
    {
        $post = new Post();
        $posts = $post->select($request, $request + 5);
        
        return $this->render('data.twig', ['posts' => $posts]);
    }

    /**
     * Return category page.
     *
     * @param string $param
     * @return mixed
     */
    public function category($param): mixed
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

    /**
     * Return post page.
     *
     * @param string $param
     * @return mixed
     */
    public function article($param): mixed
    {
        if (!empty($param)) {
            $post = new Post();
            $comment = new Comment();
            $post = $post->where('slug', '=', $param)->first();

            if (empty($post)) {
              return  Route::abord();
            }

            $comments = $comment->where('post_id', '=', $post->id)->get();

            return $this->render('article.twig', ['post' => $post, 'comments'=> $comments]);
        }

       return Route::abord();
    }

    /**
     * Send contact mail.
     *
     * @return mixed
     */
    public function contact(): mixed
    {
        Validator::create([
            "lastname" => 'Nom n\'est pas renseigné !',
            "firstname" => 'Prénom n\'est pas renseigné !',
            "email" => 'Email n\'est pas renseigné !',
            "message" => 'Message n\'est pas renseigné',
        ]);

        $mail = new Mail("pavelklimovich@hotmail.fr", "Essai de PHP Mail", "PHP Mail fonctionne parfaitement");
        $mail->send();

        return $this->redirect($_ENV['APP_URL'].'/');
    }
}
