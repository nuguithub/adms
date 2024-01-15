<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../../connectDB.php";
$email = $_POST["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $checkEmailSql = "SELECT COUNT(*) as emailCount FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $emailCount = $result->fetch_assoc()["emailCount"];


    if ($emailCount > 0) {
        $token = bin2hex(random_bytes(16)); 
        $token_hash = password_hash($token, PASSWORD_DEFAULT);
        $token_expiry_timestamp = time() + (60 * 10); // 60 seconds * 10 minutes
        $token_expiry = gmdate('Y-m-d H:i:s', $token_expiry_timestamp); // Set token expiration
    
        // Save the token and its expiration to the database
        $updateTokenSql = "UPDATE users SET token = ?, token_expiry = ? WHERE email = ?";
        $stmt = $conn->prepare($updateTokenSql);
        $stmt->bind_param("sss", $token_hash, $token_expiry, $email);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $mail = require __DIR__ . "/mailer.php";
    
            $mail->setFrom("alfred.nuguit@cvsu.edu.ph");
            $mail->addAddress($email);
            $mail->Subject = "Password Reset";
            $mail->Body = <<<END
                To reset your password, please click on the following link: <a href="http://localhost/adms/assets/resetpass/reset-password.php?email=$email&token=$token_hash">Reset Password</a>. Kindly be informed that this link will remain valid for a duration of 10 minutes.
            END;
            if ($mail->send()) {
                $_SESSION['mess123'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Email sent, please check your inbox.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                $_SESSION['mess123'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Message could not be sent. Mailer error: ' . $mail->ErrorInfo . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        } else {
            $_SESSION['mess123'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Token update failed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    } else {
        $_SESSION['mess123'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Email is not available.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    
} 

header("Location: forgot-password.php");

?>