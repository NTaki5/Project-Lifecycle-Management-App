<?php 
// Login Controller

class Login extends Controller{

    function index(){

        $errors = array();
        if(count($_POST)){
            $user = new User();
            if($row = count($user->where('email', $_POST['email'])) ? $user->where('email', $_POST['email']) : $user->where('username', $_POST['email'])){
                // print_r($row); die();
                $row = $row[0];
                if(password_verify($_POST["password"],$row->password)){
                    Auth::authenticate($row);
                    $this->redirect('home');
                }
            }

            // errors
            $errors["emailOrPassword"] = "Wrong Email or Password";
        }

        $this->view("login", [
            'errors' => $errors
        ]);
    }
}