<?php

namespace App\Controllers\Admin;


use App\Controllers\Controller;
use App\Models\Comment;
use Src\Validator\Validator;

class CommentController extends Controller
{

     /**
      * Undocumented function
      *
      * @return void
      */
    public function index()
    { 
        $comment = new Comment();
        $comments = $comment->where('verified', '=', 0)->get();
        
        return $this->render('admin/comment/index.twig', ['comments' => $comments]);
    }


     /**
      * Undocumented function
      *
      * @return void
      */
    public function valide($id)
    { 
        $comment = new Comment();
        $thisComment = $comment->where('id', '=', $id)->first();

        $comment->update(
            $thisComment->id, [
                'message'    => $thisComment->message,
                'user_id'    => $thisComment->user_id,
                'post_id'    => $thisComment->post_id,
                'verified'   => 1,
                'created_at' => $thisComment->created_at,
                'updated_at' => date("Y-m-d"),
            ]
        );
        
        $_SESSION['success'] = 'Votre commantairte est !' ;    
        $_SESSION['success_delay'] = '1';

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }


     /**
      * Undocumented function
      *
      * @return void
      */
    public function store()
    { 
        Validator::create(
            [
            "comment" => 'Le champ commentaire est pas vide !',
            "post_id" => 'Le champ post est pas vide !',
            ]
        );

        $comment = new Comment();
        $comment->create(
            [
            'message'    => $_POST['comment'],
            'user_id'    => (int)$_SESSION['auth_id'],
            'post_id'    => (int)$_POST['post_id'],
            'verified'   => 0,
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
            ]
        );

        $_SESSION['success'] = 'Votre commantairte est !' ;    
        $_SESSION['success_delay'] = '1';

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }


    /** 
     * Undocumented function
     *
     * @return void
     */
    public function delete()
    { 
        $comment = new Comment();
        $comment->delete($_POST['id']);

        $_SESSION['success'] = 'Votre commantairte est suprimé !' ;    
        $_SESSION['success_delay'] = '1';

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

}
