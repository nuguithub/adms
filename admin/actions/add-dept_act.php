<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../connectDB.php';

function addDept($conn, $dept_code, $dept_name) {

    $dept_code = strtoupper($dept_code);
    $dept_name = ucwords(strtolower($dept_name));
    
    $dept_code = mysqli_real_escape_string($conn, $dept_code);
    $dept_name = mysqli_real_escape_string($conn, $dept_name);

    $checkQuery = "SELECT COUNT(*) AS count FROM departments WHERE dept_code = '$dept_code'";
    $result = $conn->query($checkQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        
        if ($count > 0) {
            $_SESSION['messx'] = "This department already exists.";
            return false;
        } else {
            $insertQuery = "INSERT INTO departments (dept_code, dept_name) VALUES ('$dept_code', '$dept_name')";
            
            if ($conn->query($insertQuery) === TRUE) {
                $_SESSION['mess'] = "Department successfully added.";
                return true;
            } else {
                $_SESSION['messx'] = "Failed to add the department. Please try again later.";
                return false; 
            }
        }
    } else {
        return false; 
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["dept"])) {
    $dept_code = $_POST['dept_code'];
    $dept_name = $_POST['dept_name'];

    if (addDept($conn, $dept_code, $dept_name)) {
        header("Location: ../department.php");
        exit;
    } else {
        header("Location: ../department.php");
        exit;
    }
}

?>