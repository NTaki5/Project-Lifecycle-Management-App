<?php

class Model extends Database
{
    // protected $table = "users";

    function __construct(){
        if(!property_exists($this, 'table')){ //if not exist the $this->table
            $this->table = strtolower($this::class) . 's';
        }
    }

    public function where($column, $value){
        $column = addslashes($column);
        $query = "SELECT * FROM $this->table WHERE $column = :value;";
        return $this->query($query,[
            'value' => $value
        ]);
    }

    public function findAll(){

        $query = "SELECT * FROM $this->table;";
        return $this->query($query);
    }

}
