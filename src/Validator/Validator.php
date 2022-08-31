<?php

namespace Src\Validator;

class Validator
{
    public static function create(array $list)
    {
        $errors = '';
        foreach ($list as $key => $value) {
            if (!array_key_exists($key, $_POST)) {
                $errors .= $value.'<br>';
            }

            if (empty($_POST[$key])) {
                $errors .= $value.'<br>';
            }
        }

        $_SESSION['error'] = $errors ;    
        $_SESSION['error_delay'] = '1';

        if (!empty($errors)) {
            header('Location:' .$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
