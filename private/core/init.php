<?php

require "config.php";
require "database.php";
require "controller.php";
require "app.php";
require "model.php";

// inbuilt function, what is called, when a register, in our case a class is not found
// for example in controllers/Home.php => $user = new User(); this function is called
// and require the models/User.php file
spl_autoload_register(function($class_name){
    require "../private/models/" . ucfirst($class_name) . ".php";
});