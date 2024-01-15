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

if (isset($_GET['dept_id'])) {
    $deptId = intval($_GET['dept_id']);

    $sql = "DELETE FROM departments WHERE dept_id = $deptId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Departments deleted.'); 
        setTimeout(function() { window.location.href = '../department.php'; }, 1000);
        </script>";
    } else {
        echo "<script>alert('Failed to delete department.'); 
        setTimeout(function() { window.location.href = '../department.php'; }, 1000);
        </script>";
    }
}

$conn->close();
?>