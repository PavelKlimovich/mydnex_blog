<?php 

namespace App\Models;

use Src\Model\Model;

class Post extends Model
{

    public string $table = 'post';


    /**
     * Add to this Post her category.
     *
     * @return object
     */
    public function category(): object
    {
        return $this->queryJoin('category', $this->category_id);
    }

    
    /**
     * Add to this Post her author.
     *
     * @return object
     */
    public function user(): object
    {
        return $this->queryJoin('user', $this->user_id);
    }
}