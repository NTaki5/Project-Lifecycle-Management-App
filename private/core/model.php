<?php

class Model extends Database
{
    // protected $table = "users";
    public $errors = array();

    public function __construct(){
        if(!property_exists($this, 'table')){ //if not exist the $this->table
            $this->table = strtolower($this::class) . 's';
        }
    }

    public function last_inserted_id(){
        return $this->last_id();
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

    public function insert($data){
        
        if(property_exists($this, 'allowedColumns')){
            foreach ($data as $key => $column) {
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }

        if(property_exists($this, 'beforeInsert')){
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }


        // array("Volvo"=>"XC90","BMW"=>"X5","Toyota"=>"Highlander") =>
        // => Array ( [0] => Volvo [1] => BMW [2] => Toyota )
        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $values = implode(',:', $keys);

        $query = "INSERT INTO $this->table ($columns) values (:$values)";
        return $this->query($query,$data);
    }
    public function update($id, $data){

        $str = "";
        foreach ($data as $key => $value) {
            $str .= $key . " = :" . $key . ",";
        }
        $str = trim($str, ",");
        $data["id"] = $id;

        $query = "UPDATE $this->table SET $str WHERE id = :id";
        return $this->query($query,$data);
    }

    public function delete($id){

        $query = "DELETE FROM $this->table WHERE id = :id";
        return $this->query($query,[
            "id" => $id 
        ]); 
    }

    public function hash_password($data){
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        return $data;
    }

}
