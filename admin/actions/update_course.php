<?php
require_once '../../connectDB.php';

function updateCourse($id, $department_id, $course_code, $course_name)
{
    global $conn;

    $course_code = mysqli_real_escape_string($conn, $course_code);
    $course_name = mysqli_real_escape_string($conn, $course_name);

    // Fetch the current department code for the course
    $currentDeptCodeQuery = "SELECT dept_code FROM departments WHERE dept_id = '$department_id'";
    $currentDeptCodeResult = mysqli_query($conn, $currentDeptCodeQuery);

    if ($currentDeptCodeResult) {
        $currentDeptCodeRow = mysqli_fetch_assoc($currentDeptCodeResult);
        $currentDeptCode = $currentDeptCodeRow['dept_code'];

        // Update alumni_program records with the new department code
        $updateAlumniProgramQuery = "UPDATE alumni_program SET coll_dept = '$currentDeptCode' WHERE coll_course = '$course_code'";
        mysqli_query($conn, $updateAlumniProgramQuery);
    } else {
        // Handle the case where fetching current department code fails
        return false;
    }

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
        echo "<script>alert('Course updated successfully.');</script>";
        header("refresh:1;url=../course.php");
        exit();
    } else {
        echo "<script>alert('Failed to update course.');</script>";
        header("refresh:1;url=../course.php");
    }
}

$conn->close();
?>