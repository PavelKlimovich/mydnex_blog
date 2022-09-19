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


    /**
     * Generate un password.
     *
     * @return string|false|null
     */
    public function createPassword($password): string|false|null
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}
