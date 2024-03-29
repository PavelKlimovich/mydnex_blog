<?php

namespace Config;

use Dotenv\Dotenv;

class App
{

    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUsername;
    private $dbPassword;
    private $getMailFrom;
    private $getAppUrl;

    public function __construct()
    {
        
        $env = Dotenv::createImmutable(DIR);
        $env->load();

        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbPort = $_ENV['DB_PORT'];
        $this->dbName = $_ENV['DB_DATABASE'];
        $this->dbUsername = $_ENV['DB_USERNAME'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];
        $this->getMailFrom = $_ENV['EMAIL_FROM'];
        $this->getAppUrl = $_ENV['APP_URL'];
   
    }

    public function getDbHost()
    {
        return $this->dbHost;
    }

    public function getDbPort()
    {
        return $this->dbPort;
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

    public function getMailFrom()
    {
        return $this->getMailFrom;
    }

    public function getAppUrl()
    {
        return $this->getAppUrl;
    }

}
