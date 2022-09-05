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

        $this->addSessionSuccess();
        $this->addSessionError();
        $this->addAuthSession('admin');
        $this->addAuthSession('auth');
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


    public function addAuthSession(string $session)
    {
        if (isset($_SESSION[$session])) {
            $this->twig->addGlobal($session, $_SESSION[$session]);
        }
    }

    public function addSessionError()
    {
        if (isset($_SESSION['error_delay']) && $_SESSION['error_delay'] == '1') {
            $_SESSION['error_delay'] = '0';
            $this->twig->addGlobal('error', $_SESSION['error']);
        } 
    }

    public function addSessionSuccess()
    {
        if (isset($_SESSION['success_delay']) && $_SESSION['success_delay'] == '1') {
            $_SESSION['success_delay'] = '0';
            $this->twig->addGlobal('success', $_SESSION['success']);
        } 
    }

}