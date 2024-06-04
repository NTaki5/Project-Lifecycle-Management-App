<?php 
// Home Controller

class Home extends Controller{

    function index($id = ''){

        // $user = $this->load_model("User");
        $user = new User(); //autoload in config.php
        $data = isset($user->where('id',Auth::getId())[0]) ? $user->where('id',Auth::getId()) : $this->redirect("login");

        $toast = new Toast(Auth::getUsername(), "How are you today?");
        
        $this->view("home", (array)$data[0]);

    }
} 
