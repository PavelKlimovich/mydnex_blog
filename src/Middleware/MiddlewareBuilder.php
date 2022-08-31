<?php 

namespace Src\Middleware;

class MiddlewareBuilder
{
    public function init($name)
    {
        if(array_key_exists($name, $this->getList())){
            $middlewares = $this->getList();
            new $middlewares[$name]();
        }
        
    }


    public function getList()
    {
        return [
            "admin" => "App\Middlewares\AdminMiddleware"
        ];
    }
}