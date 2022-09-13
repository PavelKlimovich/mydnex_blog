<?php 

namespace Src\Middleware;

class MiddlewareBuilder
{

    /**
     * Check if middleware exist and init her.
     *
     * @param  string $name
     * @return void
     */
    public function init(string $name): void
    {
        if(array_key_exists($name, $this->getList())) {
            $middlewares = $this->getList();
            new $middlewares[$name]();
        }
    }


    /**
     * Return all middlewares.
     *
     * @return array
     */
    public function getList(): array
    {
        return [
            "admin" => "App\Middlewares\AdminMiddleware",
            "auth"  => "App\Middlewares\AuthMiddleware"
        ];
    }
}
