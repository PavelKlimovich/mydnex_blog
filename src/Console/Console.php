<?php

namespace Src\Console;

use Src\Console\Execute\ExecuteMigrate;
use Src\Console\Execute\ExecuteSeeder;
use Src\Console\Printer\Printer;


class Console extends Printer
{

    private array $arguments;

    /**
     * Run console.
     *
     * @param  array $argv
     * @return void
     */
    public function run($argv): void
    {
        $this->storeArguments($argv);
        $this->ifArgumentsNotFound();

        $this->executeCommand();

        self::getSuccess('[Success] Success !!! ', true);
    }


    /**
     * Store arguments.
     *
     * @param  array $argv
     * @return void
     */
    function storeArguments($argv): void
    {
        $this->arguments = array();

        foreach ($argv as $key => $arg) {
            if ($key >= 1) {
                $this->arguments[$key] = $arg;
            }
        }
    }


    /**
     * Verified if input not empty.
     *
     * @return void
     */
    function ifArgumentsNotFound(): void
    {
        if (empty($this->arguments)) {
            self::getError('[ERROR] Arguments not found! Please input argument.', true);
            exit(0);
        }
    }


    /**
     * Execute argument.
     *
     * @return void
     */
    function executeCommand(): void
    {
        switch ($this->getFirstArgument()) {
        case 'seed':
            new ExecuteSeeder();
            self::getSuccess('[Success] Addition to the database is successful ! ', true);
            die();
                break;
                
        case 'migrate':
            $migration = new ExecuteMigrate();
            $migration->create();
            self::getSuccess('[Success] Database is created ! ', true);
            die();
                break;

        case 'migrate:fresh':
            $migration = new ExecuteMigrate();
            $migration->fresh();
            self::getSuccess('[Success] Database is refreshed !', true);
            die();
                break;

        default:
            self::getError('[ERROR] Invalid argument !!! ', true);
            exit(0);
                break;
        }

    }


    /**
     * Return first argument.
     *
     * @return string
     */
    public function getFirstArgument(): string
    {
        return $this->arguments[1];
    }

}
