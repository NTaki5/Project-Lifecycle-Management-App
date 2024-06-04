<?php

class Auth{
    public static function authenticate($userRow){
        $_SESSION['USER'] = $userRow;
    }

    public static function logout(){
        if(isset($_SESSION['USER']))
            unset($_SESSION['USER']);
    }

    public static function is_logged_in(){
        if(isset($_SESSION['USER']))
            return true;
        else
            return false;
    }

    // is CALLED, when the Auth::someFunction not exist
    // I use it for get functions, example getUsername -> return $_SESSION['USER']->username;
    public static function __callStatic($method, $args){
        $userProperty = lcfirst(str_replace('get','',$method));
        if(isset($_SESSION['USER']->$userProperty))
            return $_SESSION['USER']->$userProperty;
        return null;
    }
}