<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

function sendMail($to, $name, $subject, $body)
{
    $mail = new PHPMailer(true);

    try{

        $mail->isSMTP();
        

        $mail->Host = "smtp.gmail.com";

        $mail->SMTPAuth = true;

        $mail->Username = "rashilromeo@gmail.com";

        $mail->Password = "ubmtxltabqfxbgdc";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;

        $mail->setFrom("rashilromeo@gmail.com", "Intern Hub");

        $mail->addAddress($to, $name);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Subject = $subject;

        $mail->Body = $body;

        return $mail->send();

    }
    catch(Exception $e){

        error_log("Mailer Error: " . $mail->ErrorInfo);
return false;

    }
}