<?php 
// Home Controller

class Home extends Controller{

    function index($id = ''){

        // $user = $this->load_model("User");
        $user = new User();

        $data = $user->where("username","taki");

        $this->view("home", $data);
    }
} 
