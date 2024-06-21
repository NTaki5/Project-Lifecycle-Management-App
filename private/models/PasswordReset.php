<?php 

class PasswordReset extends Model{

    public $allowedColumns = ["email", "token", "expires_at"];
    protected $beforeInsert = ["hash_password"];
    protected $table="password_resets";

        public function validateEmail($data){
            $this->errors = array();
            $return = true;
            $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (empty($data["email"]) || !filter_var($data["email"], FILTER_SANITIZE_EMAIL) || !preg_match($pattern,$data["email"])) {
                $this->errors["email"] = "Email is not valid";
                $return = false;
            }

            return $return;
        } 

        public function validatePassword($data){
            $this->errors = array();
            $return = true;
            if (isset($data["password"]) && (empty($data["password"]) || strcmp($data["password"], $data["password2"]))) {
                $this->errors["password"] = "Paswords do not match";
                $return = false;
            }
            return $return;
        }

}