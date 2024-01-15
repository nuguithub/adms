<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$email = $_GET['email'];
$hash_token = $_GET['token'];

require '../../connectDB.php';

$checkTokenSql = "SELECT * FROM users WHERE email = ? AND token = ? AND token_expiry > UTC_TIMESTAMP()";
$stmt = $conn->prepare($checkTokenSql);
$stmt->bind_param("ss", $email, $hash_token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // echo "Token is valid.";
    $user = $result->fetch_assoc();
    if ($email === $user['email'] && $hash_token === $user['token']) {
        // echo "Email and token match.";
        // Proceed with password reset
    } else {
        // echo "Email and token do not match the database.";
        $_SESSION['mess123'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Email and token do not match the database.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    header("Location: forgot-password.php");
        exit;
    }
} else {
    // echo "Token not found or expired.";
    $_SESSION['mess123'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Token not found or expired.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    header("Location: forgot-password.php");
                    exit;
}
?>