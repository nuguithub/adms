<?php

$currentDate = date("Y-m-d");
$previousDate = date("Y-m-d", strtotime("-1 day"));
$userIp = $_SERVER['REMOTE_ADDR'];

// Query for today's visitors
$queryToday = "SELECT * FROM `visitor` WHERE `date`='$currentDate'";
$resultToday = mysqli_query($conn, $queryToday);

if (!isset($_COOKIE['visitor'])) {
    $time = strtotime('next day 00:00');
    setcookie('visitor', 'hey', $time);
}

// Process today's visits
if ($resultToday->num_rows == 0) {
    $insertQueryToday = "INSERT INTO `visitor` (`date`, `ip`, `user_visit`) VALUES ('$currentDate', '$userIp', 1)";
    mysqli_query($conn, $insertQueryToday);
} else {
    $rowToday = $resultToday->fetch_assoc();

    if (!isset($_COOKIE['visitor'])) {
        $newIP = $rowToday['ip'];

        if (!preg_match('/' . $userIp . '/', $newIP)) {
            $newIP .= $userIp;
        }

        $updateQueryToday = "UPDATE `visitor` SET `ip` = '$newIP', `user_visit` = `user_visit` + 1 WHERE `date` ='$currentDate'";
        mysqli_query($conn, $updateQueryToday);
    }

    ob_end_flush(); // Send the output to the browser
}
?>