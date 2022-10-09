<?php

namespace Src\View\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Session\Session;
use \ParagonIE\AntiCSRF\AntiCSRF;

class Twig
{
    public $twig;

    /**
     * Init this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('../app/Views');
        $this->twig = new Environment($loader);
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
                        $csrf = new AntiCSRF();
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
     * @return void
     */
    public function initView(string $template, array $params = []): void
    {
        echo $this->twig->render($template, $params);
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
        if (Session::get($session) && Session::user_agent_matches()) {
            $this->twig->addGlobal($session, Session::get($session));
        }
    }


    /**
     * Add to twig class error global variable.
     *
     * @return void
     */
    public function addSessionError(): void
    {
        if (Session::get('error_delay') == '1') {
            Session::add('error_delay','0');
            $this->twig->addGlobal('error', Session::get('error'));
        } 
    }


    /**
     * Add to twig class success global variable.
     *
     * @return void
     */
    public function addSessionSuccess(): void
    {
        if (Session::get('success_delay') == '1') {
            Session::add('success_delay','0');
            $this->twig->addGlobal('success', Session::get('success'));
        } 
    }


    /**
     * Verify CRSF token.
     *
     * @return void
     */
    public function vefifyCSRF(): void
    {
        $csrf = new AntiCSRF();
        if (!empty($_POST)) {
            if (!$csrf->validateRequest()) {
                http_response_code(419);
                $this->initView('errors/419.html');
            }
        }
    }
}