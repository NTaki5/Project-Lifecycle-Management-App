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
                    Auth::authenticate($user->where('id', Auth::getId())[0]);
                }else{
                    $errors = $user->errors;
                }

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
                }else{
                    // errors
                    $errors = $company->errors;
                    $errors = array_merge($errors, $user->errors);
                }
                new Toast("Account successfully updated!");
                $this->redirect('accountSettings#account-details');
            }
            // Avatar or Image, or both
            if(isset($_POST['update-profile-image'])){
                if(isset($_FILES['image']) && strlen($_FILES['image']['tmp_name'])){
                    $dbImage = Auth::getImage();
                    if(strlen($dbImage)){
                        unlink("uploads/users/" . $dbImage);
                    }

                    $_POST["image"] = isset($_FILES['image']) ? add_webp_image('uploads/users/',$_FILES['image']['name'], $_FILES['image']['tmp_name']):"";

                }
                if(isset($_FILES['image']) || isset($_POST['avatar'])){
                    $user->update(Auth::getId(), $_POST);
                    Auth::authenticate($user->where('id', Auth::getId())[0]);
                }
            }

            if(isset($_POST['delete-image'])){
                $dbImage = Auth::getImage();
                if(strlen($dbImage)){
                    unlink("uploads/users/" . $dbImage);
                }

                $_POST["image"] = "";
                $user->update(Auth::getId(), $_POST);
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