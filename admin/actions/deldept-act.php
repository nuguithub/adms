<?php
session_start();
require_once '../../connectDB.php';

function check_user_role_function($requiredRole) {
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

if (isset($_GET['dept_id'])) {
    $deptId = intval($_GET['dept_id']);

    $sql = "DELETE FROM departments WHERE dept_id = $deptId";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['alert'] = ["Department deleted.", "success"];
        header("Location: ../department.php");
        exit();
    } else {
        $_SESSION['alert'] = ["Failed to delete department.", "danger"];
        header("Location: ../department.php");
        exit();
    }
}

$conn->close();
?>