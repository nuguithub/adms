<?php
include "../../connectDB.php";

$dept = $_GET['departmentx'];

$query = "SELECT DISTINCT coll_course FROM alumni_program WHERE coll_dept = '$dept'";
$result = mysqli_query($conn, $query);

$options = '<option value="">All Courses</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $row['coll_course'] . '">' . $row['coll_course'] . '</option>';
}

echo $options;
?>