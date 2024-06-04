<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'assets/PHPMailer/src/Exception.php';
require 'assets/PHPMailer/src/PHPMailer.php';
require 'assets/PHPMailer/src/SMTP.php';
// $mail = new PHPMailer(true);

class SendEmail extends PHPMailer{

    public function mySend($recipientEmail, $recipientName="", $subject, $body, $altBody=""){
         // Server settings
         $this->SMTPDebug = 0;                                       // Enable verbose debug output
         $this->isSMTP();                                            // Set mailer to use SMTP
         $this->Host       = SMTP_HOST;                     // Specify main and backup SMTP servers
         $this->SMTPAuth   = true;                                   // Enable SMTP authentication
         $this->Username   = SMTP_USERNAME;               // SMTP username
         $this->Password   = SMTP_PASSWORD;                        // SMTP password
         $this->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
         $this->Port       = 2525;                                        // TCP port to connect to

         // Recipients
         $this->setFrom(SMTP_SENDER, 'Project Lifecycle Managment');
         $this->addAddress($recipientEmail, $recipientName);                           // Add a recipient

         // Content
         $this->isHTML(true);                                        // Set email format to HTML
         $this->Subject = $subject;
         $this->Body    = $body;
         $this->AltBody = $altBody;

         // Comment this IF, if you need to check the real error in case that email not sent
         $this->send();
    }

}