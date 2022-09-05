<?php 

namespace App\Models;

use Src\Model\Model;

class User extends Model
{
    public string $table = 'user';


    public function isAdmin(): bool
    {
       if ($this->role === 'admin'){
            return true;
       }
       return false;
    }
}