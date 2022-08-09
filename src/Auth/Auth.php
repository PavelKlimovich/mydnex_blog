<?php

namespace Src\Auth;


class Auth
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $verified;
    public $role;
  

    public function __construct ($payload = null)
    {
       if (is_array($payload)){
        $this->from_array($payload);
       }
    }

    public function isAdmin(): bool
    {
       if ($this->role === 'admin'){
            return true;
       }
       return false;
    }

    public function from_array($array)
    {
       foreach(get_object_vars($this) as $attrName => $attrValue){
           $this->{$attrName} = $array[$attrName];
       }
    }
}
