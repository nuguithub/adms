<?php
require_once '../../connectDB.php';
session_start();

function updateAlumniData($id, $student_number, $fname, $mname, $lname, $birthday, $gender, $batch)
{
    global $conn;

    // Escape variables
    $student_number = mysqli_real_escape_string($conn, $student_number);
    $fname = mysqli_real_escape_string($conn, $fname);
    $mname = mysqli_real_escape_string($conn, $mname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $gender = mysqli_real_escape_string($conn, $gender);
    $batch = mysqli_real_escape_string($conn, $batch);

    // Update alumni data
    $sql = "UPDATE alumni SET student_number = '$student_number', fname = '$fname', mname = '$mname', lname = '$lname', gender = '$gender', birthday = '$birthday' WHERE alumni_id = '$id'";
    $sql1 = "UPDATE alumni_program SET batch = '$batch' WHERE alumni_id = '$id'";

    // Execute queries
    if ($conn->query($sql) === TRUE && $conn->query($sql1) === TRUE) {
        return true; // Update successful
    } else {
        return false; // Update failed
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $student_number = $_POST['student_number'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    // $coll_dept = $_POST['coll_dept'];
    // $coll_course = $_POST['coll_course'];
    $batch = $_POST['batch'];

    // Set the message before the conditional block
    $_SESSION['updAlumniMess'] = updateAlumniData($id, $student_number, $fname, $mname, $lname, $birthday, $gender, $batch)
            ? ["{$student_number} updated successfully.", "success"]
            : ["Failed to update {$student_number}.", "danger"];

    header("Location: ../alumni-directory.php");
    exit();
}

$conn->close();
?>