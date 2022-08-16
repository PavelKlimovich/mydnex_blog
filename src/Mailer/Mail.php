<?php

namespace Src\Mailer;

use Config\App;

class Mail
{
    public $to;
    public $subject;
    public $message;
    public $headers;

    public function __construct(string $to, string $subject, string $message) {
        $config = new App();
        $from = $config->getMailFrom();
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = "De :" . $from;
    }

    public function send()
    {
        mail($this->to, $this->subject, $this->message, $this->headers);

        return true;
    }
}
