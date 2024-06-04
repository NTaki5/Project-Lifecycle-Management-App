<?php

class Model extends Database
{
    // protected $table = "users";
    public $errors = array();
    public $successes = array();

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
        // Delete the $_POST columns, what are not in the DB
        $data = $this->verify_allowedColumns($data);
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
        // Delete the $_POST columns, what are not in the DB
        $data = $this->verify_allowedColumns($data);
        if(property_exists($this, 'beforeInsert')){
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }
        $str = "";
        foreach ($data as $key => $value) {
            $str .= $key . " = :" . $key . ",";
        }
        $str = trim($str, ",");
        $data["id"] = $id;
        $query = "UPDATE $this->table SET $str WHERE id = :id";
        // print_r($this->query($query,$data)); die();
        return $this->query($query,$data);
    }

    public function delete($value , $column = "id"){
        $query = "DELETE FROM $this->table WHERE $column = :val";
        return $this->query($query,[
            "val" => $value 
        ]); 
    }

    public function hash_password($data){
        if(isset($data["password"])){
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }else{
            unset($data["password"]);
        }
        return $data;
    }

    private function verify_allowedColumns($data){
        if(property_exists($this, 'allowedColumns')){
            foreach ($data as $key => $column) {
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }
        return $data;
    } 

    public function uniqueValue($column, $uniqueValue){
        if(count($this->where($column, $uniqueValue)))
            return false;
        return true;
    }

    public function myCheckDate($date){
        // $date == "06/06/2023";
        list($day, $month, $year) = explode('-', $date);
        return checkdate($month, $day, $year) ? true : false;
    }

    // Slugify a string
function slugify($text)
{
    // Strip html tags
    $text=strip_tags($text);
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    setlocale(LC_ALL, 'en_US.utf8');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Lowercase
    $text = strtolower($text);
    // Check if it is empty
    if (empty($text)) { return 'n-a'; }
    // Return result
    return $text;
}

}
