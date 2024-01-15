<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../connectDB.php';

function addCourse($conn, $department_id, $course_code, $course_name) {

    $course_code = strtoupper($course_code);
    $course_name = ucwords(strtolower($course_name));
    
    $dept_id = mysqli_real_escape_string($conn, $department_id);
    $c_code = mysqli_real_escape_string($conn, $course_code);
    $c_name = mysqli_real_escape_string($conn, $course_name);


    $checkQuery = "SELECT COUNT(*) AS count FROM courses WHERE course_code = '$c_code'";
    $result = $conn->query($checkQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        
        if ($count > 0) {
            $_SESSION['messx'] = "This course already exists.";
            return false;
        } else {
            $sql = "INSERT INTO courses (department_id, course_code, course_name) VALUES ('$dept_id', '$c_code', '$c_name')";
    
            if ($conn->query($sql) === TRUE) {
                $_SESSION['mess'] = "Course successfully added.";
                return true;
            } else {
                $_SESSION['messx'] = "Failed to add the course. Please try again later.";
                return false;
            }
        }
    } else {
        return false; 
    }
    
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crs"])) {
    $department_id = $_POST['department_id'];
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];

    if (addCourse($conn, $department_id, $course_code, $course_name)) {
        header("Location: ../course.php");
        exit;
    } else {
        header("Location: ../course.php");
        exit;
    }
}

?>