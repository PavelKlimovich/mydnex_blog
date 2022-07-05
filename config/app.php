<?php

namespace Config;

use Dotenv\Dotenv;

class App {

    private $dbHost;
    private $dbName;
    private $dbUsername;
    private $dbPassword;

    public function __construct() {
        
        $env = Dotenv::createImmutable(DIR);
        $env->load();

        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_DATABASE'];
        $this->dbUsername = $_ENV['DB_USERNAME'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];
    }

    public function getDbHost()
    {
        return $this->dbHost;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    public function getDbUsername()
    {
        return $this->dbUsername;
    }

    public function getDbPassword()
    {
        return $this->dbPassword;
    }

}