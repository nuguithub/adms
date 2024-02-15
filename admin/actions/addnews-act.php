<?php
session_start();
require_once '../../connectDB.php';

function addNewsToDatabase($title, $img, $content, $author_name)
{
    global $conn;

    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $author_name = mysqli_real_escape_string($conn, $author_name);

    $img_path = '';
    if (!empty($img)) {
        $img_name = $img['name'];
        $img_tmp = $img['tmp_name'];
        $upload_dir = '../../img/news/';
        $imageFileType = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowedImageTypes = array('jpg', 'jpeg', 'png');
    
        // Check if the file format is valid
        if (!in_array($imageFileType, $allowedImageTypes)) {
            $_SESSION['alert'] = ["Invalid file format. Only JPG, JPEG, and PNG files are allowed.", "danger"];
            header("Location: ../news.php");
            exit();
        }
    
        // Rename the file if it already exists
        $base_name = pathinfo($img_name, PATHINFO_FILENAME);
        $counter = 1;
        $new_img_name = $base_name . '.' . $imageFileType;
    
        while (file_exists($upload_dir . $new_img_name)) {
            $new_img_name = $base_name . '(' . $counter . ').' . $imageFileType;
            $counter++;
        }
    
        $img_path = $upload_dir . $new_img_name;
        $img_name = $new_img_name;
    
        if (!move_uploaded_file($img_tmp, $img_path)) {
            $_SESSION['alert'] = ["Failed to update news.", "danger"];
            header("Location: ../news.php");
            exit();
        }
    }
    

    $sql = "INSERT INTO news (title, img, content, author_name) VALUES ('$title', '$img_name', '$content', '$author_name')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $img = $_FILES['img'];
    $content = $_POST['content'];
    $author_name = $_POST['author_name'];

    if (addNewsToDatabase($title, $img, $content, $author_name)) {
        $_SESSION['alert'] = ["News added successfully.", "success"];
        header("Location: ../news.php");
        exit();
    } else {
        $_SESSION['alert'] = ["Failed to add news.", "danger"];
        header("Location: ../news.php");
        exit();
    }
}

$conn->close();
?>