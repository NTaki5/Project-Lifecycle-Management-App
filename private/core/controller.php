<?php

// main controller class

class Controller{

    public function view($view, $data = array()){

        // for example $data["user_name"] is extracted into $user_name variable
        extract($data);

        if(file_exists("../private/views/" . $view . ".view.php")){
            require ("../private/views/" . $view . ".view.php");
        }else{
            require ("../private/views/404.view.php");
        }

    }

    public function load_model($model){
        if(file_exists("../private/models/" . ucfirst($model) . ".php")){
            require ("../private/models/" . ucfirst($model) . ".php");
            return $model = new $model();
        }
        return false;
    }
}