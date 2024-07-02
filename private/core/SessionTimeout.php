<?php 

class SessionTimeout extends Controller{

    function __construct(){
        // Check if session is started and active, if not, then set the params 
        session_set_cookie_params([
            'lifetime' => 1440,
            'secure' => false, // Change to true if you are using HTTPS
            'httponly' => true, // This helps mitigate XSS attacks
        ]);

        session_start();
        $session_timeout = 1440;//24 minutes

        if (isset($_SESSION['LAST_ACTIVITY'])) {
            $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];
            if ($elapsed_time >= $session_timeout) {
                $this->index();
                exit();
            }
        }
        // Update last activity time stamp
        $_SESSION['LAST_ACTIVITY'] = time();

    }

    function index(){

        $errors = array();
        if(count($_POST)){
            $user = new User();
            if($row = count($user->where('email', $_POST['email'])) ? $user->where('email', $_POST['email']) : $user->where('username', $_POST['email'])){
                // print_r($row); die();
                $row = $row[0];
                if(password_verify($_POST["password"],$row->password)){
                    session_unset();    // Unset session variables
                    session_destroy();  // Destroy the session
                    
                    session_set_cookie_params([
                        'lifetime' => 5,
                        'secure' => false, // Change to true if you are using HTTPS
                        'httponly' => true, // This helps mitigate XSS attacks
                    ]);
                    
                    session_start();
                    Auth::authenticate($row);
                    header("Refresh:0");
                    
                }else{
                    // errors
                    $errors["emailOrPassword"] = "Wrong Email or Password";
                }
            }else{
                // errors
                $errors["emailOrPassword"] = "Wrong Email or Password";
            }

        }
        

        $this->view("session-timeout", [
            'errors' => $errors
        ]);
    }
}