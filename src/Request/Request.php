<?php

namespace Src\Request;


class Request
{
    public function __construct() {
 
        if (!is_null($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->{$key} = (string)$value;
            }
        }
    }
}