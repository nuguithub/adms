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

if (isset($_GET['course_id'])) {
    $courseId = intval($_GET['course_id']);

    $sql = "DELETE FROM courses WHERE course_id = $courseId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Course deleted.'); 
        setTimeout(function() { window.location.href = '../course.php'; }, 1000);
        </script>";
    } else {
        echo "<script>alert('Failed to delete Course.'); 
        setTimeout(function() { window.location.href = '../course.php'; }, 1000);
        </script>";
    }
}

$conn->close();
?>