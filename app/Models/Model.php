<?php 

namespace App\Models;

use Src\Database\DB;

abstract class Model
{
    public $db;
    public string $table;

    public function __construct() {
        $this->db = DB::getInstance();
    }

    public function all()
    {
        $tables = $this->db->getPDO()->query("SELECT * FROM {$this->table}");

        return $tables->fetchAll();
    }
    
}