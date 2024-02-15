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

if (isset($_GET['course_id'])) {
    $courseId = intval($_GET['course_id']);

    $sql = "DELETE FROM courses WHERE course_id = $courseId";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['alert'] = ["Course deleted.", "success"];
        header("Location: ../course.php");
        exit();
    } else {
        $_SESSION['alert'] = ["Failed to delete Course.", "danger"];
        header("Location: ../course.php");
        exit();
    }
}

$conn->close();
?>