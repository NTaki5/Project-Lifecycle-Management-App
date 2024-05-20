<?php 
// Home Controller

class Home extends Controller{

    function index($id = ''){

        // $user = $this->load_model("User");
        $user = new User(); //autoload in config.php

        $data = $user->where('id',Auth::getId());

        $this->view("home", $data);

        //Don't show the welcome toast at each page refresh
        if(!isset($_SESSION["notShowToast"])){
            $_SESSION['notShowToast'] = true;
        }
    }
} 
