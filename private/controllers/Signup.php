<?php 
// Signup Controller

class Signup extends Controller{

    function index(){

        $errors = array();
        // WHEN I HAVE TO SAVE DATA IN DB
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user = new User();
            $invitation = new Invitation();
            
            // GET token is set and validate user data  OR  validate user data and company data
            // Register from invitation link OR register as company
                $userBool = $user -> validate($_POST);
                
                if(isset($_GET['token']) && $userBool){
                    $_POST["date"] = date("Y-m-d");
                        $token = $_GET['token'];
                        $invitationRow = $invitation->where('token', $token)[0];

                        if(new DateTime($invitationRow -> expires_at) < new DateTime()){
                            $toast = new Toast();
                            $companyPhone = $user->where('fk_company_id', $invitationRow->fk_company_id)[0]->phone;
                            
                            $toast->setToast("Your registration link has expired", "Company phone number: ". $companyPhone);
                            $this->view("login", [
                                'toast' => $toast->show()
                            ]);
                            exit();
                        }
                        $invitation->update($invitationRow->id,[
                            "used" => 1
                        ]);
                        $companyID = $invitationRow -> fk_company_id;
                        if($invitationRow -> user_role == 'client'){
                            $companyID = -1;
                        }

                        $_POST["companyName"] =  "";
                        $_POST["companyCUI"] =  "";
                        $_POST["companyAddress"] =  "";
                        $_POST["companyType"] =  "";
                        $_POST["fk_company_id"] = $companyID;
                        $_POST["role"] = $invitationRow -> user_role;

                        $_POST["image"] = isset($_FILES['image']) ? add_webp_image('uploads/users/',$_FILES['image']['name'], $_FILES['image']['tmp_name']):"";
        
                        $user->insert($_POST);

                        if($invitationRow -> user_role == 'client'){
                            $companyID = -1;

                            
                            $projectUserMap = new Project();
                            $projectUserMap->table = "map_users_projects";
                            $projectUserMap->allowedColumns = ['fk_user_id', 'fk_project_id'];

                            $boolInsert = count($projectUserMap->insert([
                                'fk_user_id' => $user->last_inserted_id(),
                                'fk_project_id' => $invitationRow->fk_project_id
                            ]));
        
                            if ($boolInsert) {
                                new Toast("The project could not be created", "Try again later");
                                $projectDB = new Project();
                                $projectDB->delete($invitationRow->fk_project_id);
                                $projectUserMap->delete($invitationRow->fk_project_id, 'fk_project_id');
                            }
                        }


                        $this->redirect("login");
        
                }

                $company = new Company();
                $companyBool = $company -> validate($_POST);
                if($companyBool && $userBool){
                    $_POST["date"] = date("Y-m-d");

                    $company->insert($_POST);
                    $_POST["fk_company_id"] =  $company->last_inserted_id();
                    $_POST["role"] = "admin";
                    $_POST["image"] = isset($_FILES['image']) ? add_webp_image('uploads/users/',$_FILES['image']['name'], $_FILES['image']['tmp_name']):"";
    
                    $user->insert($_POST);
                    $this->redirect("login");
                }

                
            $errors = array_merge($user->errors, $company->errors);


            //     if(($userBool && isset($_GET['token'])) || ($companyBool && $userBool)){
            //     $_POST["date"] = date("Y-m-d");

            //     if(isset($_GET['token'])){
            //         $token = $_GET['token'];
            //         $invitation = new Invitation();
            //         $row = $invitation->where('token', $token)[0];
            //         $invitation->update($row->id,[
            //             "used" => 1
            //         ]);

            //         $_POST["companyName"] =  "";
            //         $_POST["companyCUI"] =  "";
            //         $_POST["companyAddress"] =  "";
            //         $_POST["companyType"] =  "";
            //         $_POST["fk_company_id"] =  $row -> fk_company_id;
            //         $_POST["role"] = $row -> user_role;
                    
            //     }else{
            //         $company->insert($_POST);
            //         $_POST["fk_company_id"] =  $company->last_inserted_id();
            //         $_POST["role"] = "admin";
            //     }

            //     $_POST["image"] = isset($_FILES['image']) ? add_webp_image('uploads/users/',$_FILES['image']['name'], $_FILES['image']['tmp_name']):"";

            //     $user->insert($_POST);

            //     $this->redirect("login");
            // }else{
            //     // errors
            //     $errors = array_merge($user->errors, $company->errors);
            // }
        }

        $invitationDatas = array();
        if(isset($_GET['token'])){
            $invitation = new Invitation();
            $token = $_GET['token'];
            if(!($invitationDatas = $invitation->where('token', $token)[0])){
                Toast::setToast("Invalid token");
                $this->redirect('login');
            }

            if($invitationDatas->used){
                Toast::setToast("The token has already been used");
                $this->redirect('login');
            }
            
        }
        
        $this->view("signup", [
            'invitationDatas' => $invitationDatas,
            'errors' => $errors
        ]);
    }
} 
