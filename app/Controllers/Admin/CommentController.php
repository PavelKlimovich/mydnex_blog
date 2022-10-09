<?php

namespace App\Controllers\Admin;

use Src\View\View;
use App\Models\User;
use App\Models\Comment;
use Src\Request\Request;
use Src\Session\Session;
use Src\Validator\Validator;

class CommentController
{
    private $comment;
    private $request;

    public function __construct() 
    {
        $this->comment = new Comment();
        $this->request = new Request();
    }

     /**
      * Return comment index page.
      *
      * @return void
      */
    public function index(): void
    { 
        $comments = $this->comment->where('verified', '=', '0')->get();
        
       View::get('admin/comment/index.twig', ['comments' => $comments]);
    }


    /**
     * Valide selected comment.
     *
     * @param string $id
     * @return void
     */
    public function valide(string $id): void
    { 
        $comment = $this->comment->where('id', '=', $id)->first();
        $comment->update($comment->id,['verified' => 1]);

        Session::success('Le commantaire est validé !');

        View::redirect($_SERVER['HTTP_REFERER']);
    }


    /**
     * Store selected comment.
     *
     * @return void
     */
    public function store(): void
    { 
        Validator::create([
            "comment" => 'Le champ commentaire est vide !',
            "post_id" => 'Le champ post est vide !',
        ]);
     
        if (is_null(Session::get('auth'))) {
            Session::error('L\'utilisateur n\'a pas été authentifié !');
            View::redirect($_SERVER['HTTP_REFERER']);
        }

        $user = new User();
        $user = $user->where('token','=', Session::get('auth'))->first();

        if (!isset($user->id)) {
            Session::error('L\'utilisateur n\'a pas été authentifié !');
            View::redirect($_SERVER['HTTP_REFERER']);
        }

        $this->comment->create([
            'message'    => $this->request->post('comment'),
            'user_id'    => (int)$user->id,
            'post_id'    => $this->request->post('post_id'),
            'verified'   => 0,
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);

        Session::success('Votre commentaire est en attente de modération !');

        View::redirect($_SERVER['HTTP_REFERER']);
    }


    /** 
     * Delete selected comment.
     *
     * @return void
     */
    public function delete(): void
    { 
        $this->comment->delete($this->request->post('id'));
        Session::success('Le commantairte est supprimé !');

        View::redirect($_SERVER['HTTP_REFERER']);
    }
}
