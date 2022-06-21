<?php

namespace Src\Database;

use Dotenv\Dotenv;

class DB
{
  public $_instance;
  private $host;
  private $dbName;
  private $username;
  private $password;

  public function __construct()
  {
    $env = Dotenv::createImmutable("../", '.env');
    $env->load();

    $this->host = $_ENV['DB_HOST'];
    $this->dbName = $_ENV['DB_DATABASE'];
    $this->username = $_ENV['DB_USERNAME'];
    $this->password = $_ENV['DB_PASSWORD'];

    $this->_instance = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8', $this->username, $this->password);
    $this->_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  public function getInstance()
  {
    if (is_null($this->_instance)) {
      $this->_instance = new DB();
    }
    
    return $this->_instance;
  }

}
