<?php

class Database
{
    private $con;
    private function connect(){
        if(!$this->con = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"))){
            die("Could not connect to database");
        }

        return $this->con;
    }

    public function query($query, $data = array(), $data_type = "object"){
        $this->con = $this->connect();
        $statement = $this->con->prepare($query);
        if($statement){

            $check = $statement->execute($data);
            if($check){
                if($data_type == "object"){
                    $data = $statement->fetchAll(PDO::FETCH_OBJ);
                }else{
                    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                }

                if(is_array($data)){
                    return $data;
                }
            }
        }
        die("Database error: private/core/database.php Line 31");
    }

    protected function last_id(){
        if ($this->con === null) {
            $this->connect();
        }
        return $this->con->lastInsertId();
    
    }
}
