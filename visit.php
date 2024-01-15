<?php
session_start();
include 'connectDB.php';
// Get the current date and the date for the previous day
$currentDate = date("Y-m-d");
$previousDate = date("Y-m-d", strtotime("-1 day"));
$userIp = $_SERVER["REMOTE_ADDR"];

// Query for today's views
$queryToday = "SELECT * FROM `visitor` WHERE `date`='$currentDate'";
$resultToday = mysqli_query($conn, $queryToday);

if (!isset($_COOKIE['visitor'])) {
    $time = strtotime('next day 00:00');
    setcookie('visitor', 'hey', $time);
}

// Check the user's role
if ($_SESSION['role_'] === 'alumni_admin') {
    $rowl = 'admin';
} else if ($_SESSION['role_'] === 'alumni') {
    $rowl = 'alumni';
} else if ($_SESSION['role_'] === 'college_coordinator') {
    $rowl = 'coordinator';
}

// Increment the visit count for alumni and admin
if ($rowl === 'alumni' || $rowl === 'admin' || $rowl === 'coordinator') {
    $roleVisitCountColumn = $rowl . '_visit';

    // Update the role's visit count for the current date (session-based)
    $updateRoleQToday = "UPDATE `visitor` SET `$roleVisitCountColumn` = `$roleVisitCountColumn` + 1 WHERE `date` ='$currentDate'";
    mysqli_query($conn, $updateRoleQToday);
}
?>