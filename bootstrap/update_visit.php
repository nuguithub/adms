<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = true;
    $_SESSION['visit_start_time'] = time();

    include '../connectDB.php';

    $currentDate = date('Y-m-d');
    $distinction = isset($_SESSION['user_id']) ? 'logged_in' : 'not_logged_in';

    if (!isset($_COOKIE['visit_month']) || $_COOKIE['visit_month'] !== date('Y-m')) {
        $insertQuery = "INSERT INTO page_visits (visit_count, distinction, visit_date) VALUES (1, '$distinction', '$currentDate')";
        $result = $conn->query($insertQuery);

        if (!$result) {
            echo "<script>alert('TANGA');</script>";
        }

        setcookie('visit_month', date('Y-m'), strtotime('+1 month'));
    } else {
        $updateQuery = "UPDATE page_visits SET visit_count = visit_count + 1 WHERE visit_date = '$currentDate'";
        $result = $conn->query($updateQuery);

        if (!$result) {
            echo "<script>alert('BOBO');</script>";
        }
    }

    $conn->close();
}
?>