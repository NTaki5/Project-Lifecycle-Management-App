<?php 
// Signup Controller

class Signup extends Controller{

    function index(){

        $errors = array();
        if(count($_POST)){

            $company = new Company();
            $user = new User();
            
            if($user -> validate($_POST) && $company -> validate($_POST)){

                $_POST["role"] = isset($_POST["role"])? $_POST["role"] : "admin";
                $_POST["image"] = isset($_FILES['image']) ? add_webp_image('uploads/users/',$_FILES['image']['name'], $_FILES['image']['tmp_name']):"";

                $_POST["date"] = date("Y-m-d");

                $company->insert($_POST);
                $_POST["fk_company_id"] =  $company->last_inserted_id();
                // echo'<pre>';
                // print_r($_POST); die();

                $user->insert($_POST);

                $this->redirect("login");
            }else{
                // errors
                $errors = $user->errors;
            }
        }

        $this->view("signup", [
            'errors' => $errors
        ]);
    }
} 
