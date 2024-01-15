<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$email = $_GET['email'];
$hash_token = $_GET['token'];
require "../../connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $checkTokenSql = "SELECT * FROM users WHERE email = ? AND token = ? AND token_expiry > UTC_TIMESTAMP()";
    $stmt = $conn->prepare($checkTokenSql);
    $stmt->bind_param("ss", $email, $hash_token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        if (strlen($_POST["pass"]) < 8) {
            $_SESSION["reset_prompt"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password must be at least 8 characters. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } elseif (!preg_match("/[a-z]/i", $_POST["pass"])) {
            $_SESSION["reset_prompt"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password must contain at least one letter. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } elseif (!preg_match("/[0-9]/", $_POST["pass"])) {
            $_SESSION["reset_prompt"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password must contain at least one number. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } elseif ($_POST["pass"] !== $_POST["cpass"]) {
            $_SESSION["reset_prompt"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Passwords don`t match. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $password_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("UPDATE users SET passwordx = :passwordx, token = NULL, token_expiry = NULL WHERE email = :email");
            $stmt->bindParam(':passwordx', $password_hash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $_SESSION["mess123"] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Password updated. You can now login. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

            header("Location: forgot-password.php");
            exit;
        }
        
    } else {
        $_SESSION["reset_prompt"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Token not found. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

}
?>