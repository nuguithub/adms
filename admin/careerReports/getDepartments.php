<?php
include "../../connectDB.php";

$sql = "SELECT dept_code, dept_name FROM departments";
$result = mysqli_query($conn, $sql);

$options = '<option value="">All Colleges</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $row['dept_code'] . '">' . $row['dept_name'] . '</option>';
}

echo $options;
?>