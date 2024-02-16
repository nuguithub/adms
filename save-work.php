<?php
session_start();
include 'connectDB.php';

if (isset($_POST['saveWorkx'])) {
    $company_address = $_POST['company_address'];
    $work_location = $_POST['work_location'];
    $workId = $_POST['id'];
    $empStat = $_POST['empStat'];
    $workStart = $_POST['workStart'];
    $workEnd = $_POST['workEnd'];

    if ($workEnd != '' && $workEnd != NULL) {
        if (strtotime($workStart) > strtotime($workEnd) || strtotime($workEnd) > strtotime(date('Y-m-d'))) {
            $_SESSION['workStatMess'] = ["Invalid date range. 'Work End' date should be later than 'Work Start' date and not ahead of the current date.", "danger"];
            header("Location: profile.php");
            exit();
        }
    } else {
        if (empty($workEnd)) {
            $workEnd = 'Present';
        }
    }

    // Use prepared statement for the UPDATE query
    $sqlUpdateWork = "UPDATE workHistory SET company_address = ?, work_location = ?, empStat = ?, workStart = ?, workEnd = ? WHERE work_id = ?";
    $stmtUpdateWork = mysqli_prepare($conn, $sqlUpdateWork);
    
    if ($stmtUpdateWork) {
        mysqli_stmt_bind_param($stmtUpdateWork, "sssssi", $company_address, $work_location, $empStat, $workStart, $workEnd, $workId);

        if (mysqli_stmt_execute($stmtUpdateWork)) {
            $_SESSION['workStatMess'] = ["Work information updated successfully.", "success"];
            
        } else {
            $_SESSION['workStatMess'] = ["Error updating work information.", "danger"];
        }

        mysqli_stmt_close($stmtUpdateWork);
    } else {
        $_SESSION['workStatMess'] = ["Error preparing statement.", "danger"];
    }
    header("Location: profile.php");
    exit();

    mysqli_close($conn);
}
?>