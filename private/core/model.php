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
        if(!is_array($column) && !is_array($value)){
            $column = addslashes($column);
            $query = "SELECT * FROM $this->table WHERE $column = :value;";
            return $this->query($query,[
                'value' => $value
            ]);
        }else{
            if (count($column) !== count($value)) {
                throw new InvalidArgumentException("Number of columns must match number of values");
            }
    
            $column = array_map('addslashes', $column);  // Ensure column names are safe
            $conditions = [];
            $params = [];
    
            foreach ($column as $index => $column) {
                $param = ":value$index";
                $conditions[] = "$column = $param";
                $params["value$index"] = $value[$index];
            }
    
            $conditionsStr = implode(' AND ', $conditions);
            $query = "SELECT * FROM $this->table WHERE $conditionsStr;";
    
            return $this->query($query, $params);
        }
    }

    public function findAll($where="" , $orderby='id ASC', $limit="", $groupby = ""){
        $where = strlen($where) ? "WHERE " . $where : "";
        $orderby = strlen($orderby) ? "ORDER BY " . $orderby : "";
        $limit = strlen($limit) ? "LIMIT " . $limit : "";
        $groupby = strlen($groupby) ? "GROUP BY " . $groupby : "";
        $query = "SELECT * FROM $this->table $where $groupby $orderby $limit;";
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
            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
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

    public function myCheckDate($dateString){
        $format = 'Y-m-d\TH:i';
        $dateTime = DateTime::createFromFormat($format, $dateString);
        return $dateTime && $dateTime->format($format) === $dateString;
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
