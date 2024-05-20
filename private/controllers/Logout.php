<?php 
// Logout Controller

class Logout extends Controller{

    function index(){

        if(isset($_SESSION['USER'])){
            Auth::logout();
            if(isset($_SESSION['notShowToast'])){
                unset($_SESSION['notShowToast']);
            }
            $this->redirect('login');
        }

    }
}