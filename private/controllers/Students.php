<?php 
// Students Controller

class Students extends Controller{
    function __construct(){
    }

    function index($id = ''){
        echo $this->view('students');
    }
} 
