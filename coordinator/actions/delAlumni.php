<?php
session_start();
require_once '../../connectDB.php';

if (isset($_GET['alumni_id'])) {
    $alId = intval($_GET['alumni_id']);

    $archiveSql = "UPDATE alumni SET archive = 1, archive_expiry = DATE_ADD(NOW(), INTERVAL 30 DAY) WHERE alumni_id = $alId";
    
    if ($conn->query($archiveSql) === TRUE) {
        $_SESSION['updAlumniMess'] = ['Record has been successfully archived. You can retrieve it within the next 30 days.', 'success'];
        header("Location: ../alumni-directory.php");
        exit();
    } else {
        $_SESSION['updAlumniMess'] = ['Failed to delete record.', 'danger'];
        header("Location: ../alumni-directory.php");
        exit();
    }
}

?>