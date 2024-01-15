<?php
session_start();
require_once '../../connectDB.php';

function addCoordinatorToDatabase($username, $passwordx, $cpasswordx, $role)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $username);
    $passwordx = mysqli_real_escape_string($conn, $passwordx);
    $cpasswordx = mysqli_real_escape_string($conn, $cpasswordx);
    $role = mysqli_real_escape_string($conn, $role);

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    if (!$stmt) {
        $_SESSION['coor_stat'] = "Invalid action.";
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        $_SESSION['coor_stat'] = "Invalid action.";
    }

    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['coor_stat'] = "Username already taken. Please choose a different one.";
    }
    else {
        if ($passwordx != $cpasswordx) {
            $_SESSION['coor_stat'] = "Passwords don't match.";
            return false;
        }
        else {
            $hashed_password = password_hash($passwordx, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (username, passwordx, role_) VALUES ('$username', '$hashed_password', '$role')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['coor_stat'] = "B";
                return true;
            } else {
                $_SESSION['coor_stat'] = "Failed to add user.";
                return false;
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $passwordx = $_POST['passwordx'];
    $cpasswordx = $_POST['cpasswordx'];
    $role = $_POST['role_'];

    if (addCoordinatorToDatabase($username, $passwordx, $cpasswordx,$role)) {
        header("refresh:1;url=../accounts.php");
        exit();
    } else {
        header("refresh:1;url=../accounts.php");
    }
}

$conn->close();
?>