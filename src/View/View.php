<?php

namespace Src\View;

use Src\View\Twig\Twig;

class View
{
    
    /**
     * Return twig view.
     *
     * @param  string $template
     * @param  array  $params
     * @return void
     */
    public static function get(string $template, array $params = []): void
    {   
        $twig = new Twig();
        $twig->initView($template, $params);
    }


    /**
     * Redirect to url.
     *
     * @param  string $route
     * @return void
     */
    public static function redirect(string $route): void
    {
        header('Location:' .$route);
        exit();
    }


    /**
     * Return error 404.
     *
     * @return void
     */
    public static function abord(): void
    {
        http_response_code(404);
        self::get('errors/404.html');
    }

}
