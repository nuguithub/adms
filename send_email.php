<?php
session_start();
$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';

if(empty($email)) {
    $_SESSION['registerStat'] = ["No email found.", "info"];
    header("Location: register-status.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "alfred.nuguit@cvsu.edu.ph";
$mail->Password = "gvowtwjttgnpyyiw";

$mail->isHtml(true);

try {
    $mail->setFrom("email@noreply.com");
    $to = $email;
    $mail->addAddress($to);

    $mail->Subject = 'Alumni Office Registration';
    $mail->Body = 'Thank you for registering. Please wait for the coordinator to approve your account. We will email you once it is approved.';

    $mail->send();
    
    $_SESSION['registerStat'] = ["Account created successfully, wait for the coordinator to approve your account.", "success"];
    header("Location: register-status.php");
    exit();

} catch (Exception $e) {
    $errorMessage = "Error sending email: " . $e->getMessage();

    $_SESSION['registerStat'] = [$errorMessage, "success"];
    header("Location: register-status.php");
    exit();
}
?>