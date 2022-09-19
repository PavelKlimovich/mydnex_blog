<?php

namespace Src\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use \ParagonIE\AntiCSRF\AntiCSRF;

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
        $this->vefifyCSRF();
        $this->twig->addFunction(new \Twig\TwigFunction('form_token',
                function($lock_to = null) {
                    $lock_to = $lock_to ?? $_SERVER['REQUEST_URI'];
                    static $csrf;
                    if ($csrf === null) {
                        $csrf = new AntiCSRF;
                    }
                    return $csrf->insertToken($lock_to, false);
                },
                ['is_safe' => ['html']]
            )
        );

        
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


    /**
     * Verify CRSF token.
     *
     * @return void
     */
    public function vefifyCSRF(): void
    {
        $csrf = new AntiCSRF;
        if (!empty($_POST)) {
            if (!$csrf->validateRequest()) {
                http_response_code(419);
                include '../app/Views/errors/419.php';
                exit();
            }
        }
    }

}
