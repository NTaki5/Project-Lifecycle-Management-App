<?php

class PasswordResets extends Controller{


    function index(){

        $errors = array();
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            if(isset($_POST['send-email'])){
                
                $passwordReset = new PasswordReset();
                $email = isset($_POST['email']) ? $_POST['email'] : "";

                $user = new User();
                if(!$user->uniqueValue('email', $email)){
                    if($passwordReset->validateEmail($_POST)){
                        $token = generateToken();
                        date_default_timezone_set('Europe/Bucharest');
                        
                        $passwordReset->query('DELETE FROM password_resets WHERE email = :email',['email'=>$email]);
                        $passwordReset->insert([
                            'email' => $email,
                            'token' => $token,
                            'expires_at' => date('Y-m-d H:i:s', time() + (60*60))
                        ]);
    
    
                        // Send email
                        $resetLink = ROOT . "/passwordResets/token=$token";
                        $sendeEmail = new SendEmail();
    
                        try {
            
                            $emailSubject = "ProLifeManagement password reset";
                            $emailBody = 'Hello!' . 
                            'Your password reset link: <a href="'. ROOT .'/passwordResets/reset?token=' . $token . '" target="_blank"> Click here </a>';
            
                           if(!$sendeEmail->mySend($email, $email, $emailSubject, $emailBody)){
                                new Toast("Password reset link could not be sent");
                                Header("Refresh:0");
                            }
    
                           new Toast("We have sent the password reset link to your email.");
    
                        } catch (Exception $e) {
                            print_r($e);
                        }
                        
                    }
                    $errors = $passwordReset->errors;
                }else{
                    $errors['email'] = "You are not registered with this email address!";
                }


            }

        // print_r($errors); die();

        $this->view('password-reset', [
            'errors' => $errors,
            'passwordForm' => false
        ]);
    }

    function reset(){
        $errors = array();

        if(isset($_GET['token'])){
            $token = $_GET['token'];
            $passwordReset = new PasswordReset();

            $reset = count($passwordReset->where('token', $token)) == 1 ? $passwordReset->where('token', $token)[0] : false;
            // print_r($reset);exit();
            if ($reset && strtotime($reset->expires_at) > time() - (60*60)){
                $email = $reset->email;

                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if(isset($_POST['reset-password'])){
                        if($passwordReset->validatePassword($_POST)){
                            $password = $_POST['password'];
                            
                            $user = new User();
                            $userID = $user->where('email', $email)[0]->id;
                            $user->update($userID,[
                                'password'=>$password,
                                'email' => $email
                            ]);
                            $passwordReset->delete($reset->id);
                            new Toast('Your password has been reset successfully.');
                            $this->redirect('login');
                        }
                        $errors = $passwordReset->errors;
                    }
                }
                
            }else{
                new Toast('Invalid or expired token.');
                $this->redirect('login');
            }

            $this->view('password-reset', [
                'errors' => $errors,
                'passwordForm' => true
            ]);
        }else{
            $this->redirect('login');
        }
    }
}