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
    

    /**
     * Insert new records into the database.
     *
     * @param  array  $values
     * @return bool
     */
    public function insert(array $values): bool
    {
        $insert_values = '';
        $column = '';

        if (empty($values)) {
            return false;
        }
        
        $count = 1;
        foreach ($values as $key => $value) {
            if (count($values) != $count) {
                $column .= "`".$key."`,";
                $insert_values  .= "'".$value."',";
                $count++;
            } else {
                $column .= "`".$key."`";
                $insert_values .= "'".$value."'";
                $count++;
            }
        }

        $this->db->getPDO()->query("INSERT INTO $this->table (`id`,$column) VALUES (null,$insert_values)");

        return true;
    }
}