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

if (isset($_GET['news_id'])) {
    $newsId = intval($_GET['news_id']);

    $delSql = "SELECT img FROM news WHERE news_id = $newsId";
    $result = mysqli_query($conn, $delSql);
        
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imgFilePath = '../../img/news/' . $row['img'];
        if (file_exists($imgFilePath)) {
            if (unlink($imgFilePath)) {

                $sql = "DELETE FROM news WHERE news_id = $newsId";
    
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['alert'] = ["News deleted.", "success"];
                    header("Location: ../news.php");
                    exit();
                } else {
                    $_SESSION['alert'] = ["Failed to delete news.", "danger"];
                    header("Location: ../news.php");
                    exit();
                }
            }
                    
        } else {
            $_SESSION['alert'] = ["Failed to delete news.", "danger"];
            header("Location: ../news.php");
            exit();
            }
    } else {
        $_SESSION['alert'] = ["Failed to delete news.", "danger"];
        header("Location: ../news.php");
        exit();
    }
}

$conn->close();
?>