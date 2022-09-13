<?php 

namespace Src\Model;

use Src\Database\DB;

abstract class Model
{

    public $db;
    public string $table;
    public $request;

    public function __construct($array = null)
    {
        $this->db = DB::getInstance();

        if (!is_null($array)) {
            foreach(get_object_vars($this) as $attrName => $attrValue){
                $this->{$attrName} = $array[$attrName];
            }
        }
    }


    /**
     * Prepare query request before send him.
     *
     * @param string $sql
     * @param array|null $attributes
     * @return object
     */
    public function request(string $sql, array $attributes = null): object
    {
        if($attributes !== null) {
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
     * @return mixed
     */
    public function all(): mixed
    {
        $this->request = $this->request("SELECT * FROM {$this->table}")->fetchAll(\PDO::FETCH_CLASS, $this::class);

        return $this;
    }


    /**
     * Return all entities in the model.
     *
     * @return array
     */
    public function select(int $start, int $finish): array
    {
        return $this->request("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT $start,$finish")->fetchAll(\PDO::FETCH_CLASS, $this::class);
    }


    /**
     * Return first entity in the model.
     *
     * @return object
     */
    public function queryJoin(string $table, string $value): object
    {
        $sql = "SELECT * FROM $table WHERE `id` = '".$value."'";
        $this->$table = $this->request($sql)->fetchAll(\PDO::FETCH_CLASS, $this::class);

        return $this->$table[0];
    }


    /**
     * Return all entities in the model.
     *
     * @return mixed
     */
    public function queryJoinAll(string $table, string $value): mixed
    {
        $sql = "SELECT * FROM $table WHERE `id` = '".$value."'";
        $this->$table = $this->request($sql)->fetchAll(\PDO::FETCH_CLASS, $this::class);

        return $this->$table;
    }


    /**
     * Insert new records into the database.
     *
     * @param  array $values
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
      * @param  int   $id
      * @param  array $values
      * @return bool
      */
    public function update(int $id, array $values): bool
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
     * @param  string $id
     * @return object
     */
    public function delete(string $id): object
    {
        $sql = "DELETE FROM $this->table WHERE `id` = $id";
        return $this->request($sql);
    }   
    

    /**
     * Return the funded element with id.
     *
     * @param  string $id
     * @return array||bool
     */
    public function find(string $id): array | bool
    {
        $sql = "SELECT * FROM $this->table WHERE $id";
        return $this->request($sql)->fetch();
    }


    /**
     * Execute query and return entities into the database.
     *
     * @param  string $culumn
     * @param  string $operator
     * @param  string $value
     * @return mixed
     */
    public function where(string $culumn, string $operator, string $value): mixed
    {
        $sql = "SELECT * FROM $this->table WHERE $culumn $operator '".$value."'";
        $this->request = $this->request($sql)->fetchAll(\PDO::FETCH_CLASS, $this::class);

        return $this;
    }


    /**
     * Return first query element.
     *
     * @return object
     */
    public function first(): object
    {
        return $this->request[0];
    }

    /**
     * Return all query elements.
     *
     * @return array
     */
    public function get(): array
    {
        return $this->request;
    }

}

