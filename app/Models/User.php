<?php 

namespace App\Models;

use Src\Model\Model;

class User extends Model
{
    public string $table = 'user';


    /**
     * Return boolean if this user is admin.
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        if (isset($this->role) && $this->role === 'admin') {
            return true;
        }
        return false;
    }
}
