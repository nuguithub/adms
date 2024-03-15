<?php
$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';

if(empty($email)) {
    echo "<script>
            alert('No email found.');
            window.location.href = '../alumni.php;
        </script>";
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../../vendor/autoload.php";

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

    $mail->Subject = 'Alumni Office Registration Approved';
    $mail->Body = 'Your account registration with the Alumni Office has been approved. You can now enjoy the benefits of your account.';

    $mail->send();
    
    echo "<script>alert('Status update successful');
        setTimeout(function() {
            window.location.href = '../alumni.php';
        }, 200);</script>";

} catch (Exception $e) {
    $errorMessage = "Error sending email: " . $e->getMessage();
    echo "<script>
            alert('$errorMessage');
            window.location.href = '../alumni.php';
        </script>";
}
?>