<?php
function check_user_role_function($requiredRole) {
    session_start();
    if (isset($_SESSION['role_']) && $_SESSION['role_'] === $requiredRole) {
        return true;
    }
    return false;
}

if (!check_user_role_function('college_coordinator')) {
    echo "<script>
    alert('Unauthorized Access.'); 
    setTimeout(function() { 
        window.location.href = '../index.php'; 
    }, 500);
    </script>";
    exit;
} 

header("Location: coor-dashboard.php");
exit;
?>