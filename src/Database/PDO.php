<?php

namespace Src\Database;

abstract class PDO
{
    protected $pdo;

    public function __construct($host,$dbName,$username,$password)
    {
        $this->pdo = new \PDO('mysql:host='.$host.';dbname='.$dbName.';charset=utf8', $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function connect(){
       
        return $this->pdo;
    }

}


