<?php

$delSql = "SELECT user_id, img FROM alumni WHERE archive = 1 AND archive_expiry < NOW()";
$resultax = $conn->query($delSql);

if ($resultax) {
    while ($row = $resultax->fetch_assoc()) {
        // Get user_id and img from the current row
        $user_id = $row['user_id'];
        $img = $row['img'];

        // Check if img is not null before proceeding with deletion
        if ($img !== null) {
            $imgFilePath = 'img/alumni/' . $img;

            if (file_exists($imgFilePath) && unlink($imgFilePath)) {
                // Delete user (if user_id is not null)
            }
        }

        // Delete alumni record
        $alumniDeleteSql = "DELETE FROM alumni WHERE archive = 1 AND archive_expiry < NOW()";
        if ($conn->query($alumniDeleteSql) === TRUE) {
            // echo "Records deleted successfully";
        } 

        if ($user_id !== null) {
            $userDeleteSql = "DELETE FROM users WHERE user_id = '$user_id'";
            if ($conn->query($userDeleteSql) === TRUE) {
                // echo "Records deleted successfully";
            } 
        }
    }
} 
?>