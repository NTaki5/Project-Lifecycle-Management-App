<?php

class AccountSettings extends Controller{


    function index(){

        $errors = array();
        $successes = array();
        if(count($_POST)){

            $company = new Company();
            $user = new User();
            
            if(isset($_POST["resetPassword"])){

                if($user -> passwordResetValidate($_POST)){
                    $user->update(Auth::getId(), $_POST);
                    $successes['resetPassword'] = "Password successfully changed!";
                    new Toast("Password successfully changed!");
                    Auth::authenticate($user->where('id', Auth::getId())[0]);
                }else{
                    $errors = $user->errors;
                    new Toast("Your password update failed.", "Try again!");
                }
                // new Toast("Password successfully changed!");

            }
            if(isset($_POST['edit-account-details'])){
                $companyBool = $company -> validate($_POST);
                $userBool = $user -> validate($_POST);

                
                // Authenticated User is NOT ADMIN and validate user data  OR  validate user data and company data
                // Register from invitation link OR register as company
                if(($userBool && Auth::getRole() !== 'admin') || ($companyBool && $userBool)){
                    // echo'<pre>';
                    // print_r($_POST); die();
                    $_POST["date"] = date("Y-m-d");
    
                    $company->update(Auth::getFk_company_id(), $_POST);
                    $user->update(Auth::getId(), $_POST);
                    Auth::authenticate($user->where('id', Auth::getId())[0]);   
                    // print_r($_SESSION['USER']);die();
                    $successes['accountUpdated'] = "Account successfully updated!";
                    new Toast("Account successfully updated!");
                }else{
                    // errors
                    $errors = $company->errors;
                    $errors = array_merge($errors, $user->errors);
                    new Toast("Your profile update failed.", "Try again!");
                }
                // $this->redirect('accountSettings#account-details');
            }
            // Avatar or Image, or both
            if(isset($_POST['update-profile-image'])){
                if(isset($_FILES['image']) && strlen($_FILES['image']['tmp_name'])){
                    if(file_exists(Auth::getImage(true)))
                        unlink(Auth::getImage(true));
                    

                    $_POST["image"] = isset($_FILES['image']) ? add_webp_image('uploads/users/',$_FILES['image']['name'], $_FILES['image']['tmp_name']):"";

                }
                if(isset($_FILES['image']) || isset($_POST['avatar'])){
                    $user->update(Auth::getId(), $_POST);
                    Auth::authenticate($user->where('id', Auth::getId())[0]);
                }
            }

            if(isset($_POST['delete-image'])){
                if(file_exists(Auth::getImage(true)))
                        unlink(Auth::getImage(true));

                $_POST["image"] = "";
                $user->update(Auth::getId(), $_POST);
                new Toast("Profile image successfully updated!");
                Auth::authenticate($user->where('id', Auth::getId())[0]);
            }
        }

        // print_r($errors); die();

        $this->view('account-settings', [
            'errors' => $errors,
            'successes' => $successes
        ]);
    }
}