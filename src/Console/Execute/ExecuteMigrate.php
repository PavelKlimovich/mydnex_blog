<?php

namespace Src\Console\Execute;

use Src\Database\DB;

class ExecuteMigrate
{
    private $db;

    public function __construct() {
        $this->db = DB::getInstance();
    }


    public function create()
    {
        $sgl = file_get_contents(DIR.'/database/migrations/db.sql');
        $this->db->getPDO()->query($sgl);
    }


    public function fresh()
    {
        $tables = $this->db->getAllTablesName();
        $this->deleteTable($tables);
        $this->create();
    }


    public function deleteTable(array $tables): void 
    {
        try{
            foreach($tables as $table){
                $sql =  "DROP TABLE `".$table."`";
                $this->db->getPDO()->query($sql);
            }

        }catch(\Exception $e){
            var_dump($e);
            die();
        }
        
    }
}