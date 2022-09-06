<?php 

namespace App\Models;

use Src\Model\Model;

class Post extends Model
{
    public string $table = 'post';


    public function category()
    {
        return $this->queryJoin('category', $this->category_id);
    }
}