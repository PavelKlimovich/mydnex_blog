<?php 

namespace App\Models;

use Src\Database\DB;

abstract class Model
{
    public $db;
    public string $table;

    public function __construct() {
        $this->db = new DB();
    }

    public function all()
    {
        $users =  $this->db->getInstance()->query("SELECT * FROM {$this->table}");

        return $users->fetchAll();
    }
    
}