<?php
include "../../connectDB.php";

$department = $_POST['departmentx'];
$course = $_POST['coursex'];

$sql = "SELECT 
            COUNT(CASE WHEN wh.workEnd = 'Present' AND c.related = 'YES' THEN 1 END) AS Employed,
            COUNT(CASE WHEN wh.workEnd = 'Present' AND c.related = 'NOT' THEN 1 END) AS EmployedNotInclined,
            COUNT(CASE WHEN wh.position IS NULL THEN 1 END) AS NoInfo
        FROM alumni a
        LEFT JOIN workHistory wh ON a.user_id = wh.user_id
        LEFT JOIN careers c ON wh.position = c.career_name
        LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
        WHERE 1=1";


$params = array();

if (!empty($department)) {
    $sql .= " AND ap.coll_dept = ?";
    $params[] = $department;
}

if (!empty($course)) {
    $sql .= " AND ap.coll_course = ?";
    $params[] = $course;
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

    // Fetch the result row
    $row = mysqli_fetch_assoc($result);

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    echo '<div class="container"><div class="col-9 mx-auto">';

    echo '<table class=" mt-2 table table-borderless repx">';
    echo '<tbody>';
    
    echo "<tr><th class='w-50 text-center'>Employed</th><td class='w-25'>{$row['Employed']}</td></tr>";
    echo "<tr><th class='text-center'>Employed but not Inclined</th><td>{$row['EmployedNotInclined']}</td></tr>";
    echo "<tr><th class='text-center'>No info</th><td>{$row['NoInfo']}</td></tr>";

    echo '</tbody>';
    echo '</table>';
    echo '</div></div>';
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

mysqli_close($conn);
?>