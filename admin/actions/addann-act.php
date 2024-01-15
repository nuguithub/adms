<?php
require_once '../../connectDB.php';

function addAnnouncementToDatabase($title, $img, $content, $event_date, $event_time, $venue, $organizer)
{
    global $conn;

    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $event_date = mysqli_real_escape_string($conn, $event_date);
    $event_time = mysqli_real_escape_string($conn, $event_time);
    $venue = mysqli_real_escape_string($conn, $venue);
    $organizer = mysqli_real_escape_string($conn, $organizer);
    
    $img_path = '';
    if (!empty($img)) {
        $img_name = $img['name'];
        $img_tmp = $img['tmp_name'];
        $img_path = '../../img/announcement/' . $img_name;

        $imageFileType = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowedImageTypes = array('jpg', 'jpeg', 'png');
        if (!in_array($imageFileType, $allowedImageTypes)) {
            echo "<script>alert('Invalid file format. Only JPG, JPEG, and PNG files are allowed.');</script>";
            return false;
        }

        // Rename the file if it already exists
        $base_name = pathinfo($img_name, PATHINFO_FILENAME);
        $counter = 1;
        $new_img_name = $base_name . '.' . $imageFileType;
    
        while (file_exists('../../img/announcement/' . $new_img_name)) {
            $new_img_name = $base_name . '(' . $counter . ').' . $imageFileType;
            $counter++;
        }
    
        $img_path = '../../img/announcement/' . $new_img_name;
        $img_name = $new_img_name;

        if (!move_uploaded_file($img_tmp, $img_path)) {
            echo "<script>alert('Failed to upload image.');</script>";
            return false;
        }
    }

    $sql = "INSERT INTO announcements (title, img, content, event_date, event_time, venue, organizer) VALUES ('$title', '$img_name', '$content', '$event_date', '$event_time', '$venue', '$organizer')";
    
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
    $event_date= $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $venue = $_POST['venue'];
    $organizer = $_POST['organizer'];

    if (addAnnouncementToDatabase($title, $img, $content, $event_date, $event_time, $venue, $organizer)) {
        echo "<script>alert('Announcement added successfully.');</script>";
        header("refresh:1;url=../announcement.php");
        exit();
    } else {
        echo "<script>alert('Failed to add Announcement.');</script>";
        header("refresh:1;url=../announcement.php");
    }
}

$conn->close();
?>