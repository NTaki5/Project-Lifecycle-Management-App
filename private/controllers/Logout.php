<?php 
// Logout Controller

class Logout extends Controller{

    function index(){

        if(isset($_SESSION['USER'])){
            $user = new User();
            $user->update(Auth::getId(),["online" => 0 ]);
            
            Auth::logout();
            if(isset($_SESSION['notShowToast'])){
                unset($_SESSION['notShowToast']);
            }
            $this->redirect('login');
        }

    }
}