<?php

namespace Src\Console\Execute;

use Src\Database\DB;

class ExecuteMigrate
{
    private $db;

    public function __construct() {
        $this->db = DB::getInstance();

        $sgl = file_get_contents(DIR.'/database/migrations/db.sql');
        self::create($sgl);
    }



    public function create($sgl)
    {
        $this->db->getPDO()->query($sgl);
    }
}