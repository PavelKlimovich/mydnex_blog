<?php

namespace Src\Mailer;

use Config\App;
use Src\Session\Session;

class Mail
{
    public $to;
    public $subject;
    public $message;
    public $headers;

    public function __construct(string $subject, string $message, string $to = null, string $from = null) 
    {
        $config = new App();
        $from = $from ?? $config->getMailFrom();
        $this->to = $to ?? $config->getMailFrom();
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = "De :" . $from;
    }


    /**
     * Send mail.
     *
     * @return bool
     */
    public function send(): bool
    {   
        try {
            mail($this->to, $this->subject, $this->message, $this->headers);
            Session::success('Votre message a été envoyé !');
            return true;
        } catch (\Throwable $th) {
            Session::error('Une erreur s\'est produite, votre message n\'a pas été envoyé !');
            return false;
        }
    }
}
