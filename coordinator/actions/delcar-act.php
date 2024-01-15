<?php
require_once '../../connectDB.php';

function check_user_role_function($requiredRole) {
    session_start();
    if (isset($_SESSION['role_']) && $_SESSION['role_'] === $requiredRole) {
        return true;
    }
    return false;
}

if (!check_user_role_function('college_coordinator')) {
    echo "<script>alert('Unauthorized Access.'); 
    setTimeout(function() { window.location.href = '../../index.php'; }, 1000);
    </script>";
    exit;
}

if (isset($_GET['career_id'])) {
    $careerId = intval($_GET['career_id']);

    $deleteSql = "DELETE FROM careers WHERE career_id = $careerId";
    if ($conn->query($deleteSql) === TRUE) {
            echo "<script>alert('Career deleted.'); 
            setTimeout(function() { window.location.href = '../career.php'; }, 1000);
            </script>";
    } else {
        echo "<script>alert('Failed to delete Career.'); 
        setTimeout(function() { window.location.href = '../career.php'; }, 1000);
        </script>";
    }
    
}

$conn->close();
?>