<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../connectDB.php';

function addCourse($conn, $department_id, $course_code, $course_name) {

    $course_code = strtoupper($course_code);
    $course_name = ucwords(strtolower($course_name));
    $small_words = array("of", "and", "in", "at");

    foreach ($small_words as $small_word) {
        $course_name = preg_replace("/\b" . $small_word . "\b/i", strtolower($small_word), $course_name);
    }
    
    
    $dept_id = mysqli_real_escape_string($conn, $department_id);
    $c_code = mysqli_real_escape_string($conn, $course_code);
    $c_name = mysqli_real_escape_string($conn, $course_name);


    $checkQuery = "SELECT COUNT(*) AS count FROM courses WHERE course_code = '$c_code'";
    $result = $conn->query($checkQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        
        if ($count > 0) {
            $_SESSION['alert'] = ["This course already exists.", "danger"];
            return false;
        } else {
            $sql = "INSERT INTO courses (department_id, course_code, course_name) VALUES ('$dept_id', '$c_code', '$c_name')";
    
            if ($conn->query($sql) === TRUE) {
                $_SESSION['alert'] = ["Course successfully added.", "success"];
                return true;
            } else {
                $_SESSION['alert'] = ["Failed to add the course. Please try again later.", "danger"];
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