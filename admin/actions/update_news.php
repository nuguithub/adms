<?php
require_once '../../connectDB.php';

function updateNews($id, $title, $img, $content, $created_at, $author)
{
    global $conn;

    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $created_at = mysqli_real_escape_string($conn, $created_at);
    $author = mysqli_real_escape_string($conn, $author);

    $sql_select_image = "SELECT img FROM news WHERE news_id = '$id'";
    $result = $conn->query($sql_select_image);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_img_name = $row['img'];

        if (!empty($img['name'])) {
            // Delete the old image
            $upload_dir = '../../img/news/';
            $current_img_path = $upload_dir . $current_img_name;
            if (file_exists($current_img_path)) {
                unlink($current_img_path);
            }

            // Rename the file if it already exists
            $base_name = pathinfo($img['name'], PATHINFO_FILENAME);
            $counter = 1;
            $new_img_name = $base_name . '.' . strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));

            while (file_exists($upload_dir . $new_img_name)) {
                $new_img_name = $base_name . '(' . $counter . ').' . strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
                $counter++;
            }

            $img_path = $upload_dir . $new_img_name;

            if (!move_uploaded_file($img['tmp_name'], $img_path)) {
                echo "<script>alert('Failed to upload image.');</script>";
                return false;
            }

            $sql = "UPDATE news SET img = '$new_img_name', title = '$title', content = '$content', created_at = '$created_at', author_name = '$author' WHERE news_id = '$id'";
            
        } else {
            $sql = "UPDATE news SET title = '$title', content = '$content', created_at = '$created_at', author_name = '$author' WHERE news_id = '$id'";
        }
    } else {
        echo "<script>alert('News record not found.');</script>";
        return false;
    }

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $img = $_FILES['img'];
    $content = $_POST['content'];

    $date = $_POST["news_date"];
    $time = $_POST["news_time"];
    $created_at = date("Y-m-d H:i", strtotime("$date $time"));
    
    $author = $_POST['author'];

    if (updateNews($id, $title, $img, $content, $created_at, $author)) {
        echo "<script>alert('News updated successfully.');</script>";
        header("refresh:1;url=../news.php");
        exit();
    } else {
        echo "<script>alert('Failed to update news.');</script>";
        header("refresh:1;url=../news.php");
    }
}

$conn->close();
?>