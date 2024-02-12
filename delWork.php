<?php
session_start();
require_once 'connectDB.php';

if (isset($_GET['id'])) {
    $wId = intval($_GET['id']);

    $sql = "DELETE FROM workHistory WHERE work_id = $wId";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['workStatMess'] = ["Work experience deleted.", "success"];
                    
    } else {
        $_SESSION['workStatMess'] = ["Failed to delete work experience.", "danger"];
        
    }
}
header("Location: profile.php");
exit();
$conn->close();
?>