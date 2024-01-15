<?php
include "../../connectDB.php";

$department = $_POST['department'];
$course = $_POST['course'];
$batch = $_POST['batch'];

$sql = "SELECT * FROM alumni_program WHERE 1=1";
$params = array();

if (!empty($department)) {
    $sql .= " AND coll_dept = ?";
    $params[] = $department;
}

if (!empty($course)) {
    $sql .= " AND coll_course = ?";
    $params[] = $course;
}

if (!empty($batch)) {
    $sql .= " AND batch = ?";
    $params[] = $batch;
}

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    if (!empty($params)) {
        // Dynamically bind parameters
        $paramTypes = str_repeat("s", count($params));
        mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
    }

    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        // Output data as needed
        // For example, echo $row['alumni_name'], etc.
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

$totalCount = mysqli_num_rows($result);
echo "<hr><p class='fw-bolder text-center mt-5 py-2 bg-black text-light'>Total Number: <span class='fw-normal px-5'>".$totalCount."</span></p>";
mysqli_close($conn);
?>