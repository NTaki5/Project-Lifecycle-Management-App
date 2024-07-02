<?php 

class Task extends Model{

    public $allowedColumns = ["title", "description", "fk_category_id", "fk_company_id", "fk_project_id", "createdBy_id", "priority"];


        public function validate($data){
            $this->errors = array();
            $return = true;
            if(empty($data["title"]) || !preg_match("/^[a-z. A-Z]+$/",$data["title"])){
                $this->errors["title"] = "Only letters allowed in task name";
                $return = false;
            }

            return $return;
        } 

        public function getAllTaskCategory($where="" , $orderby='id ASC', $limit="", $groupby = ""){
            $this->table = "task_categories";
            return $this->findAll($where, $orderby, $limit, $groupby);
        }
        public function getTaskCategoryWhere($column, $value){
            $this->table = "task_categories";
            return $this->where($column, $value);
        }
        public function addTaskCategory($data){
            $this->table = "task_categories";
            $this->insert($data);
        }
        public function editTaskCategory($categoryID,$data){
            $this->table = "task_categories";
            $this->update($categoryID, $data);
        }
        
        public function deleteTaskCategory($categoryID){
            $this->table = "task_categories";
            $this->delete($categoryID);
        }
}