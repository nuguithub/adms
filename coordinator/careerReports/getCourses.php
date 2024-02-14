<?php
include "../../connectDB.php";

$dept = $_GET['departmentx'];

$getDeptID = "SELECT dept_id FROM departments WHERE dept_code = '$dept'";
$DeptIDResult = mysqli_query($conn, $getDeptID);
$row = mysqli_fetch_assoc($DeptIDResult);
$dept_ID = $row['dept_id'];

$query = "SELECT * FROM courses WHERE department_id = '$dept_ID' GROUP BY department_id, course_code";
$result = mysqli_query($conn, $query);

$options = '<option value="">All Courses</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $row['course_code'] . '">' . $row['course_name'] . '</option>';
}

echo $options;
?>