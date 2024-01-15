<?php
session_start();
require_once '../../connectDB.php';

function addCoordinatorToDatabase($coll, $username, $passwordx, $cpasswordx)
{
    global $conn;

    $coll = mysqli_real_escape_string($conn, $coll);
    $username = mysqli_real_escape_string($conn, $username);
    $passwordx = mysqli_real_escape_string($conn, $passwordx);
    $cpasswordx = mysqli_real_escape_string($conn, $cpasswordx);

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
        if (empty($coll)) {
            $_SESSION['coor_stat'] = "Choose college department.";
            return false;
        }

        if ($passwordx != $cpasswordx) {
            $_SESSION['coor_stat'] = "Passwords don't match.";
            return false;
        } else {
            $hashed_password = password_hash($passwordx, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (username, passwordx, role_, college) VALUES ('$username', '$hashed_password', 'college_coordinator', '$coll')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['coor_stat'] = "B";
                return true;
            } else {
                $_SESSION['coor_stat'] = "Failed to add coordinator.";
                return false;
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $coll = $_POST['college'];
    $username = $_POST['username'];
    $passwordx = $_POST['passwordx'];
    $cpasswordx = $_POST['cpasswordx'];

    if (addCoordinatorToDatabase($coll, $username, $passwordx, $cpasswordx)) {
        header("refresh:1;url=../coordinator.php");
        exit();
    } else {
        header("refresh:1;url=../coordinator.php");
    }
}

$conn->close();
?>