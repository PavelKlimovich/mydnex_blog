<?php

namespace Src\Database;

use Dotenv\Dotenv;

class DB
{
  private static $_instance;
  private $host;
  private $dbName;
  private $username;
  private $password;
  private $pdo;

  private function __construct()
  {
    $env = Dotenv::createImmutable("../", '.env');
    $env->load();

    $this->host = $_ENV['DB_HOST'];
    $this->dbName = $_ENV['DB_DATABASE'];
    $this->username = $_ENV['DB_USERNAME'];
    $this->password = $_ENV['DB_PASSWORD'];

    $this->pdo = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8', $this->username, $this->password);
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  
  public static function getInstance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new DB();
    }
    
    return self::$_instance;
  }
  
  public function getPDO()
  {
    return $this->pdo;
  }
}
