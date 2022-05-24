<?php

namespace Src\Routing;
class Route
{
    public static function get($route, $fn)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') !== 0) {
            return;
        }

        self::on($route, $fn);
    }

    public static function post($route, $callback)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0) {
            return;
        }

        self::on($route, $callback);
    }

    public static function on($url, $fn)
    {
        $request = $_SERVER['REQUEST_URI'];

        if ($request === $url) {

            $params = 'null';
            // TODO :: Add return error not found.
            return $fn; 

        } else {
            http_response_code(404);
            require '../app/Views/errors/404.php';
        }
    }
}