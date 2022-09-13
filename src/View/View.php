<?php

namespace Src\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class View
{
    protected $twig;

    /**
     * Init this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('../app/Views');
        $this->twig   = new Environment($loader);
        $this->twig->getExtension(\Twig\Extension\CoreExtension::class)->setTimezone('Europe/Paris'); 

        $this->addSessionSuccess();
        $this->addSessionError();
        $this->addAuthSession('admin');
        $this->addAuthSession('auth');
    }


    /**
     * Return twig view.
     *
     * @param  string $template
     * @param  array  $params
     * @return mixed
     */
    public function render(string $template, array $params = []): mixed
    {
        echo $this->twig->render($template, $params);
        exit();
    }


    /**
     * Redirect to url.
     *
     * @param  string $route
     * @return mixed
     */
    public function redirect(string $route): mixed
    {
        header('Location:' .$route);
        exit();
    }


    /**
     * Add to twig class auth global variable.
     *
     * @param  string $session
     * @return void
     */
    public function addAuthSession(string $session): void
    {
        if (isset($_SESSION[$session])) {
            $this->twig->addGlobal($session, $_SESSION[$session]);
        }
    }


    /**
     * Add to twig class error global variable.
     *
     * @return void
     */
    public function addSessionError(): void
    {
        if (isset($_SESSION['error_delay']) && $_SESSION['error_delay'] == '1') {
            $_SESSION['error_delay'] = '0';
            $this->twig->addGlobal('error', $_SESSION['error']);
        } 
    }


    /**
     * Add to twig class success global variable.
     *
     * @return void
     */
    public function addSessionSuccess(): void
    {
        if (isset($_SESSION['success_delay']) && $_SESSION['success_delay'] == '1') {
            $_SESSION['success_delay'] = '0';
            $this->twig->addGlobal('success', $_SESSION['success']);
        } 
    }

}
