<?php

namespace Src\Console\Execute;

use Src\Database\DB;

class ExecuteMigrate
{
    private $db;

    public function __construct() {
        $this->db = DB::getInstance();
    }


    /**
     * Init database.
     *
     * @return void
     */
    public function create(): void
    {
        $sgl = file_get_contents(DIR.'/database/migrations/db.sql');
        $this->db->getPDO()->query($sgl);
    }


    /**
     * Delete all tables in database and init new empty tables.
     *
     * @return void
     */
    public function fresh(): void
    {
        $tables = $this->db->getAllTablesName();
        $this->deleteTable($tables);
        $this->create();
    }

    
    /**
     * Delete table in database.
     *
     * @param array $tables
     * @return void
     */
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