<?php

class Project extends Model
{

    public $allowedColumns = ["title","status", "description", "priority", "start_date", "end_date", "fk_teamlead_id", "color", "slug"];

    // functions before insert the data in DB
    protected $beforeInsert = array();

    public function validate($data)
    {

        $this->errors = array();
        $return = true;
        $user = new User();
        if (!isset($data["title"]) || !preg_match("/^[\p{L}\p{N} ]+$/u", $data["title"])) {
            $this->errors["title"] = "You must specify the title and be careful not to contain any symbols";
            $return = false;
        }

        if (!empty($data["start_date"]) && $this->myCheckDate($data["start_date"])) {
            $this->errors["start_date"] = "Invalid date";
            $return = false;
        }

        if (!empty($data["end_date"]) && $this->myCheckDate($data["end_date"])) {
            $this->errors["end_date"] = "Invalid date";
            $return = false;
        }

        if (!isset($data["priority"]) && in_array(["low","medium","high"], $data["priority"])) {
            $this->errors["priority"] = "The selected priority does not exist";
            $return = false;
        }

        if (!isset($data["color"]) || !preg_match('/^#[0-9a-f]{6}$/i', $data["color"])) {
            $this->errors["color"] = "The selected color does not exist";
            $return = false;
        }

        if (empty($data["fk_teamlead_id"])) {
            $this->errors["fk_teamlead_id"] = "Please select the Team Leader";
            $return = false;
        }

        if (!empty($data["fk_teamlead_id"]) && $user->uniqueValue("id",$data["fk_teamlead_id"])) {
            $this->errors["fk_teamlead_id"] = "The selected user does not exist";
            $return = false;
        }

        if(isset($data["team_members"])){

            foreach ($data["team_members"] as $key => $value) {
                if($user->uniqueValue("id",$value)){
                    $this->errors["team_members"] = "One team member does not exist";
                    $return = false;
                }
            }

        }else{
            $this->errors["team_members"] = "Please select the Team members";
            $return = false;
        }
        
        return $return;
    }

}
