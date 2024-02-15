<?php
session_start();
require_once '../../connectDB.php';

function updateCourse($id, $department_id, $course_code, $course_name)
{
    global $conn;

    $course_code = mysqli_real_escape_string($conn, $course_code);
    $course_name = mysqli_real_escape_string($conn, $course_name);

    // Update the courses table
    $sql = "UPDATE courses SET department_id = '$department_id', course_code = '$course_code', course_name = '$course_name' WHERE course_id = '$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $department_id = $_POST['department_id'];
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];

    if (updateCourse($id, $department_id, $course_code, $course_name)) {
        $_SESSION['alert'] = ["Course updated successfully.", "success"];
        header("Location: ../course.php");
        exit();
    } else {
        $_SESSION['alert'] = ["Failed to update course.", "danger"];
        header("Location: ../course.php");
        exit();
    }
}

$conn->close();
?>