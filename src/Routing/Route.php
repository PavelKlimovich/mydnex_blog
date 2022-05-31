<?php

namespace Src\Routing;
class Route
{
    public static function get($route, $class, $action)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') !== 0) {
            return;
        }

        self::on($route, $class, $action);
    }

    public static function post($route, $class, $action)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0) {
            return;
        }

        self::on($route, $class, $action);
    }

    public static function on($url, $class, $action)
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $route = preg_replace("/(^\/)|(\/$)/","", $url);
            $request =  preg_replace("/(^\/)|(\/$)/", "", $_SERVER['REQUEST_URI']);
        } else {
            $request = "/";
        }

        if ($request === $route) {

            // TODO :: Add return error not found.
            $params = 'null';

            return call_user_func(array($class, $action)); 
        } 

    }

    public static function abord(){
        http_response_code(404);
        require '../app/Views/errors/404.php';
        exit();
    }
}