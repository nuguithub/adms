<?php
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
            echo "<script>alert('Invalid file format. Only JPG, JPEG, and PNG files are allowed.');</script>";
            return false;
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
            echo "<script>alert('Failed to upload image.');</script>";
            return false;
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
        echo "<script>alert('News added successfully.');</script>";
        header("refresh:1;url=../news.php");
        exit();
    } else {
        echo "<script>alert('Failed to add News.');</script>";
        header("refresh:1;url=../news.php");
    }
}

$conn->close();
?>