<?php
include 'connectDB.php';

if (isset($_POST['saveWorkx'])) {
    $workId = $_POST['id'];
    $empStat = $_POST['empStat'];
    $workStart = $_POST['workStart'];
    $workEnd = $_POST['workEnd'];

    if ($workEnd != '' && $workEnd != NULL) {
        if (strtotime($workStart) > strtotime($workEnd) || strtotime($workEnd) > strtotime(date('Y-m-d'))) {
            echo "<script>alert('Invalid date range. Work End date should be later than Work Start date and not ahead of the current date.');
                    setTimeout(function() {
                    window.location.href = 'profile.php';
                    }, 300); </script>";
            exit; // Exit to prevent further execution
        }
    } else {
        if (empty($workEnd)) {
            $workEnd = 'Present';
        }
    }

    // Use prepared statement for the UPDATE query
    $sqlUpdateWork = "UPDATE workHistory SET empStat = ?, workStart = ?, workEnd = ? WHERE work_id = ?";
    $stmtUpdateWork = mysqli_prepare($conn, $sqlUpdateWork);
    
    if ($stmtUpdateWork) {
        mysqli_stmt_bind_param($stmtUpdateWork, "sssi", $empStat, $workStart, $workEnd, $workId);

        if (mysqli_stmt_execute($stmtUpdateWork)) {
            echo "<script>alert('Work information updated successfully.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 100); </script>";
        } else {
            echo "<script>alert('Error updating work information.');
                    setTimeout(function() {
                    window.location.href = 'profile.php';
                    }, 300); </script>";
        }

        mysqli_stmt_close($stmtUpdateWork);
    } else {
        // Error preparing the statement
        echo "<script>alert('Error preparing statement.');
                setTimeout(function() {
                window.location.href = 'profile.php';
                }, 300); </script>";
    }

    mysqli_close($conn);
}
?>