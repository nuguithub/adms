<?php
session_start();
require_once '../../connectDB.php';

function updateDepartments($id, $dept_code, $dept_name)
{
    global $conn;

    $dept_code = mysqli_real_escape_string($conn, $dept_code);
    $dept_name = mysqli_real_escape_string($conn, $dept_name);

    $sql = "UPDATE departments SET dept_code = '$dept_code', dept_name = '$dept_name' WHERE dept_id = '$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $dept_code = $_POST['dept_code'];
    $dept_name = $_POST['dept_name'];

    if (updateDepartments($id, $dept_code, $dept_name)) {
        $_SESSION['alert'] = ["Departments updated successfully.", "success"];
        header("Location: ../department.php");
        exit();
    } else {
        $_SESSION['alert'] = ["Failed to update departments.", "danger"];
        header("Location: ../department.php");
        exit();
    }
}

$conn->close();
?>