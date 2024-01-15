<?php
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
        echo "<script>alert('Departments updated successfully.');</script>";
        header("refresh:1;url=../department.php");
        exit();
    } else {
        echo "<script>alert('Failed to update departments.');</script>";
        header("refresh:1;url=../department.php");
    }
}

$conn->close();
?>