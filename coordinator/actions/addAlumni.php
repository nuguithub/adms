<?php
session_start();

$college = $_SESSION['college'];
require_once '../../connectDB.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addAlumni'])) {
    $student_number = $_POST["studentNumber"];
    $fname = ucwords(strtolower($_POST["fname"]));
    $mname = ucwords(strtolower($_POST["mname"]));
    $lname = ucwords(strtolower($_POST["lname"]));
    $gender = $_POST["gender"];
    $civil_status = $_POST["civil_status"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $department = $college;
    $course = $_POST["course"];
    $batch = $_POST["batch"];



        // Proceed with the database operations
        $checkQuery = "SELECT student_number FROM alumni WHERE student_number = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $student_number);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $_SESSION['updAlumniMess'] = ["A student with the same student number already exists.", "warning"];
        } else {
                
            $addAlumniQuery = "INSERT INTO alumni (student_number, fname, mname, lname, gender, civil_status, birthday, address_) 
                            VALUES ('$student_number', '$fname', '$mname', '$lname', '$gender', '$civil_status', '$birthday', '$address')";
            $alumniInsertResult = mysqli_query($conn, $addAlumniQuery);
                
            if ($alumniInsertResult) {
            $lastInsertedId = mysqli_insert_id($conn);
                
                $insertProgramQuery = "INSERT INTO alumni_program (alumni_id, coll_dept, coll_course, batch) 
                                    VALUES ('$lastInsertedId', '$college', '$course', '$batch')";
                $programInsertResult = mysqli_query($conn, $insertProgramQuery);
                
                if ($programInsertResult) {
                    $_SESSION['updAlumniMess'] = ["Alumni record added successfully.", "success"];
                    header("Location: ../alumni-directory.php");
                    exit();
                } else {
                    $_SESSION['updAlumniMess'] = ["Failed to add program information.", "danger"];
                    header("Location: ../alumni-directory.php");
                    exit();
                }
                
            } else {
                $_SESSION['updAlumniMess'] = ["Failed to add alumni record.", "danger"];
            }
        }

        header("Location: ../alumni-directory.php");
        exit();
    
}

?>