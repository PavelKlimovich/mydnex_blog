<?php

namespace Src\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    /**
     * Return Twig template.
     *
     * @param  string  $template
     * @return void
     */

    public static function view(string $template)
    {
        $loader = new FilesystemLoader('../app/Views');
        $twig   = new Environment($loader);

        echo $twig->render($template);
        exit();
    }
}