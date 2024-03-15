<?php
session_start();
require_once 'connectDB.php';

if (isset($_GET['id'])) {
    $aId = intval($_GET['id']);

    $sql = "DELETE FROM achievements WHERE id = $aId";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['educStat'] = ["Work experience deleted.", "success"];
                    
    } else {
        $_SESSION['educStat'] = ["Failed to delete work experience.", "danger"];
        
    }
}
header("Location: profile.php");
exit();
$conn->close();
?>