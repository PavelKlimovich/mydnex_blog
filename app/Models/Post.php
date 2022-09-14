<?php 

namespace App\Models;

use Src\Model\Model;

class Post extends Model
{

    public string $table = 'post';


    /**
     * Add to this Post her category.
     *
     * @return object|null
     */
    public function category(): ?object
    {
        return isset($this->category_id) ? $this->queryJoin('category', $this->category_id) : null ;
    }

    
    /**
     * Add to this Post her author.
     *
     * @return object|null
     */
    public function user(): ?object
    {
        return isset($this->user_id) ? $this->queryJoin('user', $this->user_id) : null ;
    }
}
