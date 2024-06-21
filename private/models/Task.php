<?php 

class Task extends Model{

    public $allowedColumns = ["title", "description", "status", "fk_company_id", "fk_project_id", "priority"];


        public function validate($data){
            $this->errors = array();
            $return = true;
            if(empty($data["title"]) || !preg_match("/^[a-z. A-Z]+$/",$data["title"])){
                $this->errors["title"] = "Only letters allowed in task name";
                $return = false;
            }

            return $return;
        } 

}