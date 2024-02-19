<?php
session_start();
require_once '../../connectDB.php';

if (isset($_GET['alumni_id'])) {
    $alId = intval($_GET['alumni_id']);

    $archiveSql = "UPDATE alumni SET archive = NULL, archive_expiry = NULL WHERE alumni_id = $alId";
    
    if ($conn->query($archiveSql) === TRUE) {
        $_SESSION['updAlumniMess'] = ['Record has been successfully retrieved.', 'success'];
        header("Location: ../archive.php");
        exit();
    } else {
        $_SESSION['updAlumniMess'] = ['Failed to retrieve record.', 'danger'];
        header("Location: ../archive.php");
        exit();
    }
}

?>