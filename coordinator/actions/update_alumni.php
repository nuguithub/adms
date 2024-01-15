<?php
require_once '../../connectDB.php';

function updateAlumniData($id, $student_number, $fname, $lname, $gender, $batch)
{
    global $conn;

    $student_number = mysqli_real_escape_string($conn, $student_number);
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $gender = mysqli_real_escape_string($conn, $gender);
    // $coll_dept = mysqli_real_escape_string($conn, $coll_dept);
    // $coll_course = mysqli_real_escape_string($conn, $coll_course);
    $batch = mysqli_real_escape_string($conn, $batch);
        
    $sql = "UPDATE alumni SET student_number = '$student_number', fname = '$fname', lname = '$lname', gender = '$gender', batch = '$batch' WHERE alumni_id = '$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $student_number = $_POST['student_number'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender= $_POST['gender'];
    // $coll_dept = $_POST['coll_dept'];
    // $coll_course = $_POST['coll_course'];
    $batch = $_POST['batch'];

    if (updateAlumniData($id, $student_number, $fname, $lname, $gender, $batch)) {
        echo "<script>alert('".$student_number." updated successfully.');</script>";
        header("refresh:1;url=../alumni-directory.php");
        exit();
    } else {
        echo "<script>alert('Failed to update announcement".$student_number.".');</script>";
        header("refresh:1;url=../alumni-directory.php");
    }
}

$conn->close();
?>