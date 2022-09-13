<?php 

namespace App\Models;

use Src\Model\Model;

class Comment extends Model
{

    public string $table = 'comment';

    
    /**
     * Add to this Comment her author.
     *
     * @return object
     */
    public function user(): object
    {
        return $this->queryJoin('user', $this->user_id);
    }

}