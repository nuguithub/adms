<?php
session_start();
require_once '../../connectDB.php';

function check_user_role_function($requiredRole) {
    if (isset($_SESSION['role_']) && $_SESSION['role_'] === $requiredRole) {
        return true;
    }
    return false;
}

if (!check_user_role_function('alumni_admin')) {
    echo "<script>alert('Unauthorized Access.'); 
    setTimeout(function() { window.location.href = '../../index.php'; }, 1000);
    </script>";
    exit;
}

if (isset($_GET['announcement_id'])) {
    $annId = intval($_GET['announcement_id']);

    $delSql = "SELECT img FROM announcements WHERE announcement_id = $annId";
    $result = mysqli_query($conn, $delSql);
        
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imgFilePath = '../../img/announcement/' . $row['img'];
        if (file_exists($imgFilePath)) {
            if (unlink($imgFilePath)) {

                $sql = "DELETE FROM announcements WHERE announcement_id = $annId";
    
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['alert'] = ["Announcement deleted.", "success"];
                    header("Location: ../announcement.php");
                    exit();
                } else {
                    $_SESSION['alert'] = ["Failed to delete Announcement.", "danger"];
                    header("Location: ../announcement.php");
                    exit();
                }
            }
                    
        } else {
            $_SESSION['alert'] = ["Failed to delete Announcement.", "danger"];
            header("Location: ../announcement.php");
            exit();
            }
    } else {
        $_SESSION['alert'] = ["Failed to delete Announcement.", "danger"];
        header("Location: ../announcement.php");
        exit();
    }
}

$conn->close();
?>