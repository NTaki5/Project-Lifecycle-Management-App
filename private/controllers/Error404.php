<?php 

class Error404 extends Controller{


    function index(){
        echo "404";
        $this->view("404");
    }
}