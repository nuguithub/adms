<?php
session_start();
require_once '../../connectDB.php';

function updateAnnouncementToDatabase($id, $title, $img, $content, $event_date, $event_time, $venue, $organizer)
{
    global $conn;

    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $event_date = mysqli_real_escape_string($conn, $event_date);
    $event_time = mysqli_real_escape_string($conn, $event_time);
    $venue = mysqli_real_escape_string($conn, $venue);
    $organizer = mysqli_real_escape_string($conn, $organizer);

    $sql_select_image = "SELECT img FROM announcements WHERE announcement_id = '$id'";
    $result = $conn->query($sql_select_image);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_img_name = $row['img'];

        if (!empty($img['name'])) {
            // Delete the old image
            $upload_dir = '../../img/announcement/';
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
                $_SESSION['alert'] = ["Failed to upload image.", "danger"];
                header("Location: ../announcement.php");
                exit();
            }

            $sql = "UPDATE announcements SET img = '$new_img_name', title = '$title', content = '$content', event_date = '$event_date', event_time = '$event_time', venue = '$venue', organizer = '$organizer' WHERE announcement_id = '$id'";
        
        } else {
            $sql = "UPDATE announcements SET title = '$title', content = '$content', event_date = '$event_date', event_time = '$event_time', venue = '$venue', organizer = '$organizer' WHERE announcement_id = '$id'";
        }
    } else {
        $_SESSION['alert'] = ["Announcement record not found.", "danger"];
        header("Location: ../announcement.php");
        exit();
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
    $event_date= $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $venue = $_POST['venue'];
    $organizer = $_POST['organizer'];

    if (updateAnnouncementToDatabase($id, $title, $img, $content, $event_date, $event_time, $venue, $organizer)) {
        $_SESSION['alert'] = ["Announcement updated successfully.", "success"];
        header("Location: ../announcement.php");
        exit();
    } else {
        $_SESSION['alert'] = ["Failed to update Announcement.", "danger"];
        header("Location: ../announcement.php");
        exit();
    }
}

$conn->close();
?>