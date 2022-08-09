<?php

namespace Src\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class View
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('../app/Views');
        $this->twig   = new Environment($loader);
    }

    public function render(string $template, array $params = [])
    {
        echo $this->twig->render($template, $params);
        exit();
    }

    public function redirect(string $route)
    {
        header('Location:' .$route);
        exit();
    }
}