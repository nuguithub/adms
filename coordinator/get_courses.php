<?php
require_once('../connectDB.php');

if (isset($_GET['department'])) {
    $department = $_GET['department'];

    $query = "SELECT course_code, course_name, dept_code 
        FROM courses 
        INNER JOIN departments
        ON courses.department_id = departments.dept_id
        WHERE dept_code = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $department);
    $stmt->execute();
    
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');

    echo json_encode($courses);
}
?>