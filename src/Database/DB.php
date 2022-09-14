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

        $this->pdo = new \PDO('mysql:host=' . $config->getDbHost() . ';dbname=' . $config->getDbName()  . ';charset=utf8', $config->getDbUsername(), $config->getDbPassword());
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }


    /**
     * Return this Database instance.
     *
     * @return object
     */
    public static function getInstance(): object
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new DB();
        }
    
        return self::$_instance;
    }
  

    /**
     * Return property PDO.
     *
     * @return void
     */
    public function getPDO()
    {
        return $this->pdo;
    }


    /**
     * Return all table names.
     *
     * @return array
     */
    public function getAllTablesName(): array
    {
        $sql = "SHOW TABLES";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $tables = $statement->fetchAll();
        $dbTablesList = array();
    
        foreach($tables as $table){
            $dbTablesList[] = $table[0];
        }

        return $dbTablesList;
    }

}
