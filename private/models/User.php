<?php 

class User extends Model
{

    protected $allowedColumns = ["username", "email", "password", "firstname", "lastname", "Birthday", "companyName", "companyCUI", "companyAddress", "companyType", "date", "role", "fk_company_id", "image", "avatar"];
    
    // functions before insert the data in DB
    protected $beforeInsert = ["hash_password"];

        public function validate($data){

            $this->errors = array();
            $return = true;
            
            if(empty($data["username"])){
                $this->errors["username"] = "You must give us the username";
                $return = false;
            }
            
            if(strlen($data["username"]) < 6){
                $this->errors["username"] = "The username must be at least 6 characters";
                $return = false;
            }
            
            if(empty($data["firstname"]) || !preg_match("/^[a-zA-Z]+$/",$data["firstname"])){
                $this->errors["firstname"] = "You must give us the firstname";
                $return = false;
            }
            
            if(empty($data["lastname"]) || !preg_match("/^[a-zA-Z]+$/",$data["lastname"])){
                $this->errors["lastname"] = "You must give us the lastname";
                $return = false;
            }
            
            if(empty($data["Birthday"])){
                $this->errors["Birthday"] = "You must give us your birthday";
                $return = false;
            }
            
            if(empty($data["email"]) || !filter_var($data["email"], FILTER_SANITIZE_EMAIL)){
                $this->errors["email"] = "Email is not valid";
                $return = false;
            }
            
            if(empty($data["password"]) || strcmp($data["password"], $data["password2"])){
                $this->errors["password"] = "Paswords do not match";
                $return = false;
            }

            return $return;
        } 


}
