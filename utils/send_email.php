<?php

use PHPMailer\PHPMailer\PHPMailer;

require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";

function sendEmail($email, $subject, $message)
{
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "noahsarkshelterofficial1@gmail.com";
        $mail->Password = "qict mnti pbvg eonj";
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";
        $mail->isHTML(true);
        $mail->setFrom("noreply@gmail.com");
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        return true;
    } catch (Exception $error) {
        return false;
    }
}
