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
    $_SESSION['careerMess'] = ["Unauthorized Access.", "danger"];
    header("Location: ../../index.php");
    exit;
}

if (isset($_GET['career_id'])) {
    $careerId = intval($_GET['career_id']);

    $deleteSql = "DELETE FROM careers WHERE career_id = $careerId";
    if ($conn->query($deleteSql) === TRUE) {
        $_SESSION['careerMess'] = ["Career deleted.", "success"];
        header("Location: ../career.php");
        exit;
    } else {
        $_SESSION['careerMess'] = ["Failed to delete Career.", "danger"];
        header("Location: ../career.php");
        exit;
    }
}

$conn->close();
?>