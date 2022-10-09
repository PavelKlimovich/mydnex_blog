<?php

namespace Src\Request;

use Src\Session\Session;


class Request
{
    public function __construct() 
    {
        if (!is_null($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->{$key} = (string)$value;
            }
        }
    }

    /**
     * Return POST request property.
     *
     * @param string $value
     * @return string|null
     */
    public function post(string $value): ?string 
    {
        if (!isset($this->$value)) {
            Session::error('Le champ '.$this->$value.' est vide !');
            header('Location:' .$_SERVER['HTTP_REFERER']);
            exit();
        }
        
        return $this->$value ?? null;
    }
}