<?php

class Team extends Controller
{


    public function index()
    {
        $errors = array();
        $invitations = new Invitation();
        $user = new User();

        // AN AJAX CALL from team.js, because the form is controled by Javascript, without page refresh
        if (isset($_POST['send-email'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $token = generateToken();
            $sendeEmail = new SendEmail();


            try {

                if(!$invitations->uniqueValue('email', $email))
                    throw new Exception("We have already sent an invitation to this email address.", 999);


                $emailSubject = "CMS Invitation";
                $emailBody = 'Hello, ' . $name . '! You have been invited to the ' . Auth::getCompanyName() . ' company. <br>
                Please confirm your account with this link: <a href="'. ROOT . '/signup?token=' . $token . '">'
                 . ROOT . '/signup?token=' . $token;
                $altBody = 'Hello, ' . $name . '! You have been invited to the ' . Auth::getCompanyName() . ' company.';

               $sendeEmail->mySend($email, $name, $emailSubject, $emailBody, $altBody);
                
                // Here the e-mail has been sent
                
                $invitations->insert([
                    "fk_company_id" => Auth::getFk_company_id(),
                    "fk_project_id" => 2,
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone,
                    "token" => $token,
                    "expires_at" => date('Y-m-d', strtotime('+48 hours')),
                    "user_role" => "employee"
                ]);
                Toast::setToast("Invitation has been sent", "");

                // Send a custom error response
                header('Content-Type: application/json');
                // get a HTML string from Toast::show("show toast-onload") only if the toast is seted $_SESSION['show-toast']
                echo json_encode(['value' => Toast::show("show toast-onload")]);
            } catch (Exception $e) {
                // if you want to display email error message:  "Mailer Error: {$mail->ErrorInfo}"
                if((int)$e->getCode() == (int)999){
                    Toast::setToast($e->getMessage());
                }else{
                    Toast::setToast("The invitation could not be sent.", "Try later.");
                }

                // Send a custom error response
                header('Content-Type: application/json');
                http_response_code(400); // Set a 4xx or 5xx status code
                // get a HTML string from Toast::show("show toast-onload") only if the toast is seted $_SESSION['show-toast']
                echo json_encode(['value' => Toast::show("show toast-onload"), 'code' => 999]);
            }
            exit();
        }

        // Another AJAX call from team.js
        if (isset($_POST['edit-user'])) {

            if (!isset($_POST['email'])) exit();
            if (empty($user->where('email', $_POST['email']))) {
                // to display email error message:  "Mailer Error: {$mail->ErrorInfo}"
                Toast::setToast("Not allowed to change the email address");

                // Send a custom error response
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['value' => Toast::show("show toast-onload"), 'code' => 999]);
                exit();
            }

            $userId = $user->where('email', $_POST['email'])[0]->id;

            if(!isset($_POST['userId']) || !isset($userId)) exit();

            if((int)$_POST['userId'] !== (int)$userId) exit();
   
            $userId = $_POST['userId'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $boolUpdate = $user->update($userId, [
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
            ]);

            if (!empty($boolUpdate)) {
                
                // to display email error message:  "Mailer Error: {$mail->ErrorInfo}"
                Toast::setToast("User data could not be saved.", "Try later.");

                // Send a custom error response
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['value' => Toast::show("show toast-onload"), 'code' => 999]);
                exit();
            }

            Toast::setToast("User data has been saved.", "");

            // Send a custom error response
            header('Content-Type: application/json');
            // get a HTML string from Toast::show("show toast-onload") only if the toast is seted $_SESSION['show-toast']
            echo json_encode(['value' => Toast::show("show toast-onload")]);
            exit();
        }

        // Another AJAX call from team.js
        if (isset($_POST['delete-user'])) {

            if (!isset($_POST['email'])) exit();
            if (empty($user->where('email', $_POST['email']))) {
                if (empty($invitations->where('email', $_POST['email']))) {
                    exit();
                }
                
                $invitationId = $invitations->where('email', $_POST['email'])[0]->id;
                
                $boolUpdate = $invitations->delete($invitationId);

            }else{
                $userId = $user->where('email', $_POST['email'])[0]->id;

                // tests for more precision delete from database
                if(!isset($_POST['userId']) || !isset($userId)) exit();

                if((int)$_POST['userId'] !== (int)$userId) exit();
                
                $boolUpdate = $user->delete($userId);
                if($userId === Auth::getId()) Auth::logout();
            }

            if (!empty($boolUpdate)) {
                // to display email error message:  "Mailer Error: {$mail->ErrorInfo}"
                Toast::setToast("User could not be deleted.", "Try later.");

                // Send a custom error response
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['value' => Toast::show("show toast-onload"), 'code' => 999]);
                exit();
            }

            Toast::setToast("User has been deleted.", "");

            // Send a custom error response
            header('Content-Type: application/json');
            // get a HTML string from Toast::show("show toast-onload") only if the toast is seted $_SESSION['show-toast']
            echo json_encode(['value' => Toast::show("show toast-onload")]);
            exit();
        }

        $invitations = $invitations->showInTeamTable();
        $teamMembers = $user->showInTeamTable();

        $this->view('team', [
            'errors' => $errors,
            'invitations' => $invitations,
            'teamMembers' => $teamMembers
        ]);
    }
}
