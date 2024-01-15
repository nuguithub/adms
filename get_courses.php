<?php
require_once 'connectDB.php'; 

if (isset($_GET['dept_code'])) {
    $selectedDepartment = $_GET['dept_code'];

    $deptQuery = mysqli_prepare($conn, "SELECT dept_id FROM departments WHERE dept_code = ?");
    mysqli_stmt_bind_param($deptQuery, "s", $selectedDepartment);
    mysqli_stmt_execute($deptQuery);
    $deptResult = mysqli_stmt_get_result($deptQuery);

    if ($deptResult && $deptRow = mysqli_fetch_assoc($deptResult)) {
        $dept_id = $deptRow['dept_id'];

        $coursesQuery = mysqli_prepare($conn, "SELECT * FROM courses WHERE department_id = ?");
        mysqli_stmt_bind_param($coursesQuery, "i", $dept_id);
        mysqli_stmt_execute($coursesQuery);

        $coursesResult = mysqli_stmt_get_result($coursesQuery);

        $courses = [];
        while ($row = mysqli_fetch_assoc($coursesResult)) {
            $courses[] = $row;
        }

        echo json_encode($courses);
    } else {
        echo json_encode([]);
    }
}
?>