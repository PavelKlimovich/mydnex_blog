<?php 

namespace Src\Model;

use Src\Database\DB;

abstract class Model
{
    public $db;
    public string $table;

    public function __construct() {
        $this->db = DB::getInstance();
    }


    /**
     * Prepare query request before send him.
     *
     * @return object
     */
    public function request(string $sql, array $attributes = null): object
    {
        if($attributes !== null){
            $query = $this->db->getPDO()->prepare($sql);
            $query->execute($attributes);
            return $query;
        }else{
            return $this->db->getPDO()->query($sql);
        }
    }


    /**
     * Return all entities in the model.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->request("SELECT * FROM {$this->table}")->fetchAll();
    }
    /**
     * Return all entities in the model.
     *
     * @return array
     */
    public function first(int $start, int $finish): array
    {
        return $this->request("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT $start,$finish")->fetchAll();
    }
    

    /**
     * Insert new records into the database.
     *
     * @param  array  $values
     * @return bool
     */
    public function create(array $values): bool
    {
        $insert_values = array();
        $column = array();

        if (empty($values)) {
            return false;
        }
        
        foreach ($values as $key => $value) {
            $column[] = "`".$key."`";
            $insert_values[] = "'".$value."'";
        }

        $column        = implode(', ', $column);
        $insert_values = implode(', ', $insert_values);

        $sql = "INSERT INTO $this->table (`id`,$column) VALUES (null,$insert_values)";
        $this->request($sql);

        return true;
    }


     /**
     * Update the selected records into the database.
     *
     * @param  int $id
     * @param  array $values
     * @return bool
     */
    public function update(int $id, array $values)
    {
        $insert_values = [];

        if (empty($values)) {
            return false;
        }
        
        foreach ($values as $key => $value) {
            $insert_values[] = "`".$key."` = '$value' ";
        }

        $insert_values = implode(', ', $insert_values);

        $sql = "UPDATE $this->table SET $insert_values WHERE `id` = $id";
        $this->request($sql);

        return true;
    }


    /**
     * Delete element with element id in DB.
     *
     * @param string $id
     * @return object
     */
	public function delete(string $id): object
    {
        $sql = "DELETE FROM $this->table WHERE $id ";
        return $this->request($sql);
    }   
    

    /**
     * Return the funded element with id.
     *
     * @param string $id
     * @return array||bool
     */
    public function find(string $id): array | bool
    {
        $sql = "SELECT * FROM $this->table WHERE $id";
        return $this->request($sql)->fetch();
    }


    /**
     * Return the funded element.
     *
     * @param string $culumn
     * @param string $operator
     * @param string $value
     * @return array||bool
     */
    public function where(string $culumn, string $operator, string $value): array | bool
    {
        $sql = "SELECT * FROM $this->table WHERE $culumn $operator '".$value."'";
        return $this->request($sql)->fetchAll();
    }

}