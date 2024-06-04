<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/Exception.php';
require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
$mail = new PHPMailer(true);

try {
    //Server settings verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'mail.theprismaplatform.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = '_mainaccount@theprismaplatform.com';                     // SMTP username
    $mail->Password   = '4?5VgjG*$ug3Hg';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('_mainaccount@digitalromania.ro', 'Digital Romania');
    // Add a recipient
    $mail->addAddress("fischerotto413@gmail.com");               // Name is optional
    //mailto:horia.nes@gmail.com
    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    // Set email format to HTML
    $mail->Subject = "Oferta";
    $mail->Body  = <<<DELIMITER
        
DELIMITER;

    $mail->AltBody = 'Activate account: https://theprismaplatform.com/activate.php?email=$email&code=$validation_code';

    $mail->send();
} catch (Exception $e) {
    echo $e;
}
