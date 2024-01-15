<?php
require_once '../../connectDB.php';

function check_user_role_function($requiredRole) {
    session_start();
    if (isset($_SESSION['role_']) && $_SESSION['role_'] === $requiredRole) {
        return true;
    }
    return false;
}

if (!check_user_role_function('alumni_admin')) {
    echo "<script>alert('Unauthorized Access.'); 
    setTimeout(function() { window.location.href = '../../index.php'; }, 1000);
    </script>";
    exit;
}

if (isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);

    $sql = "DELETE FROM users WHERE user_id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Coordinator deleted.'); 
        setTimeout(function() { window.location.href = '../coordinator.php'; }, 1000);
        </script>";
    } else {
        echo "<script>alert('Failed to delete Coordinator.'); 
        setTimeout(function() { window.location.href = '../coordinator.php'; }, 1000);
        </script>";
    }
}

$conn->close();
?>