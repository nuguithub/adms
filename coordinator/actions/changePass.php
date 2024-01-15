<?php
session_start();
require_once '../../connectDB.php';

function changePass($currentPass, $newPass, $confirmPass)
{
    global $conn;

    $currentPass = mysqli_real_escape_string($conn, $currentPass);
    $newPass = mysqli_real_escape_string($conn, $newPass);
    $confirmPass = mysqli_real_escape_string($conn, $confirmPass);

    $sql = "SELECT * FROM users WHERE username= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!empty($row)) {
        
        $hashedPassword = $row["passwordx"];
        $password = PASSWORD_HASH($newPass, PASSWORD_DEFAULT);
            
        if (password_verify($currentPass, $hashedPassword)) {
            if ($newPass != $confirmPass) {

                $_SESSION['user_stat'] = "Passwords don't match.";
                return false;

            } else {
                
                if ($currentPass === $newPass) {
                    $_SESSION['user_stat'] = "Current password and new password is the same.";
                    return false;
                }
                else {
                    $sql = "UPDATE users SET passwordx=? WHERE username=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $password, $_SESSION["username"]);
                    $stmt->execute();
                    $_SESSION['user_stat'] = "A";
                    return true;
                }
            }
        } else {

            $_SESSION['user_stat'] = "Current password is not correct";
            return false;
            
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changePass"])) {
    $currentPass = $_POST["currentPass"];
    $newPass = $_POST["newPass"];
    $confirmPass = $_POST["confirmPass"];

    if (changePass($currentPass, $newPass, $confirmPass)) {
        header("refresh:1;url=../account-settings.php");
        exit();
    } else {
        header("refresh:1;url=../account-settings.php");
        exit();
    }
}

$conn->close();
?>