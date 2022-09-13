<?php

namespace Src\Routing;

use Closure;
use Src\Middleware\MiddlewareBuilder as Middleware;

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
            $objectController = new $class();
            return $objectController->$action(); 
        } 

        preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);
        $param = implode(",", $paramMatches[0]);

        if (!empty($param)) {
            if (strpos($route, $param)) {
                $route = str_replace("/{".$param."}", "", $route);
                $param = explode("/", $request);
                $param = end($param);
                $request = str_replace("/".$param, "", $request);
              
                if($request === $route){
                    $objectController = new $class();
                    return $objectController->$action($param);
                }
            }
        }
    }


    /**
     * Init widdleware.
     *
     * @param string $name
     * @param Closure $closure
     * @return void
     */
    public static function middleware($name , Closure $closure): void
    {
       $middleware = new Middleware();
       $middleware->init($name);
       $closure();
    }


    /**
     * Return error 400.
     *
     * @return mixed
     */
    public static function abord(): mixed
    {
        http_response_code(404);
        require '../app/Views/errors/404.php';
        exit();
    }

}