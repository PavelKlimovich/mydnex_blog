<?php

namespace Src\Database;

use Config\App;

class DB
{
  private static $_instance;
  private $pdo;

  private function __construct()
  {
    $config = new App();

    $this->pdo = new \PDO('mysql:host=' . $config->getDbHost() . ';dbname=' . $config->getDbName()  . ';charset=utf8', $config->getDbUsername() , $config->getDbPassword() );
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
