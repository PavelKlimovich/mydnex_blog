<?php

namespace Src\Console\Printer;

use Src\Console\Printer\Colors;


class Printer
{
    public $string;
    
    public function __construct()
    {
        $this->string = new Colors();
    }
    
    /**
     * Print colored string
     *
     * @param  string $text
     * @param  string $color
     * @param  string $bgColor
     * @return void
     */
    public function printText(string $text, string $color, string $bgColor): void
    {
        print($this->string->getStringColor($text, $color, $bgColor));
    }


    /**
     * Print Error message.
     *
     * @param  string  $text
     * @param  boolean $bool
     * @return void
     */
    public function getError(string $text, bool $bool): void
    {
        $color = $bool ? 'white' : 'red';
        $background = $bool ? 'red' : 'none';

        print($this->string->getStringColor($text, $color, $background));
    }


    /**
     * Print Success message.
     *
     * @param  string  $text
     * @param  boolean $bool
     * @return void
     */
    public function getSuccess(string $text, bool $bool): void
    {
        $color = $bool ? 'white' : 'green';
        $background = $bool ? 'green' : 'none';

        print($this->string->getStringColor($text, $color, $background));
    }


    /**
     * Print Success message.
     *
     * @param  string  $text
     * @param  boolean $bool
     * @return void
     */
    public function getWarning(string $text, bool $bool): void
    {
        $color = $bool ? 'white' : 'yellow';
        $background = $bool ? 'yellow' : 'none';

        print($this->string->getStringColor($text, $color, $background));
    }

}
