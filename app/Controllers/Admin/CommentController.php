<?php

namespace App\Controllers\Admin;


use App\Models\Comment;
use Src\Request\Request;
use Src\Validator\Validator;
use App\Controllers\Controller;

class CommentController extends Controller
{

     /**
      * Return comment index page.
      *
      * @return mixed
      */
    public function index(): mixed
    { 
        $comment = new Comment();
        $comments = $comment->where('verified', '=', '0')->get();
        
        return $this->view('admin/comment/index.twig', ['comments' => $comments]);
    }


     /**
      * Valide selected comment.
      *
      * @param string $id
      * @return mixed
      */
    public function valide(string $id): mixed
    { 
        $comment = new Comment();
        $thisComment = $comment->where('id', '=', $id)->first();

        $comment->update($thisComment->id, [
                'message'    => $thisComment->message,
                'user_id'    => $thisComment->user_id,
                'post_id'    => $thisComment->post_id,
                'verified'   => 1,
                'created_at' => $thisComment->created_at,
                'updated_at' => date("Y-m-d"),
            ]);
        
        $_SESSION['success'] = 'Le commantaire est validé !' ;    
        $_SESSION['success_delay'] = '1';

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }


    /**
     * Store selected comment.
     *
     * @return mixed
     */
    public function store(): mixed
    { 
        $request = new Request();
        Validator::create([
            "comment" => 'Le champ commentaire est vide !',
            "post_id" => 'Le champ post est vide !',
        ]);

        $comment = new Comment();
        $comment->create([
            'message'    => $request->comment,
            'user_id'    => (int)$request->auth_id,
            'post_id'    => (int)$request->post_id,
            'verified'   => 0,
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ]);

        $_SESSION['success'] = 'Votre commentaire est en attente de modération !' ;    
        $_SESSION['success_delay'] = '1';

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }


    /** 
     * Delete selected comment.
     *
     * @return mixed
     */
    public function delete(): mixed
    { 
        $request = new Request();
        $comment = new Comment();
        $comment->delete($request->id);

        $_SESSION['success'] = 'Le commantairte est supprimé !' ;    
        $_SESSION['success_delay'] = '1';

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

}
