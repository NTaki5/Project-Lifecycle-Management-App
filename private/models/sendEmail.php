<?php
new SendEmail();
class SendEmail extends Model{

    public function __construct() {
        if (isset($_POST['send-email'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $invitation = new Invitation();

            $token = $this->generateToken();

            print_r($invitation);
        
            // $mail = new PHPMailer(true);
        
            // try {
            //     // Server settings
            //     $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            //     $mail->isSMTP();                                            // Set mailer to use SMTP
            //     $mail->Host       = 'smtp.example.com';                     // Specify main and backup SMTP servers
            //     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            //     $mail->Username   = 'your_email@example.com';               // SMTP username
            //     $mail->Password   = 'your_password';                        // SMTP password
            //     $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            //     $mail->Port       = 587;                                    // TCP port to connect to
        
            //     // Recipients
            //     $mail->setFrom('from@example.com', 'Mailer');
            //     $mail->addAddress($email, $name);                           // Add a recipient
        
            //     // Content
            //     $mail->isHTML(true);                                        // Set email format to HTML
            //     $mail->Subject = 'Form Submission';
            //     $mail->Body    = 'Thank you, ' . $name . '! Your form has been submitted successfully.';
            //     $mail->AltBody = 'Thank you, ' . $name . '! Your form has been submitted successfully.';
        
            //     $mail->send();
            //     echo 'Message has been sent';
            // } catch (Exception $e) {
            //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // }
        }
    }    
    
    public function generateToken() {
        return bin2hex(random_bytes(16));
    }
}