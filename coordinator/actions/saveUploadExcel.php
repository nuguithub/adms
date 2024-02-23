<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../../connectDB.php';

foreach ($_SESSION['successData'] as $data) {
    // Extract data fields
    $student_number = $data['student_number'];
    $first_name = $data['first_name'];
    $middle_name = $data['middle_name'];
    $last_name = $data['last_name'];
    $gender = $data['gender'];
    $civil_status = $data['civil_status'];
    $birthday = $data['birthday'];
    $address = $data['address'];

    $coll_dept = $data['coll_dept'];
    $coll_course = $data['coll_course'];
    $batch = $data['batch'];

    // Process and save the data to the database
    $insertQueryAlumni = "INSERT INTO alumni (student_number, fname, mname, lname, gender, civil_status, birthday, address_) 
                VALUES ('$student_number', '$first_name', '$middle_name', '$last_name', '$gender', '$civil_status', '$birthday', '$address')";
    mysqli_query($conn, $insertQueryAlumni);

    // Get the last inserted alumni_id
    $lastInsertedId = mysqli_insert_id($conn);

    $insertQueryProgram = "INSERT INTO alumni_program (alumni_id, coll_dept, coll_course, batch) 
                            VALUES ('$lastInsertedId', '$coll_dept', '$coll_course', '$batch')";
    mysqli_query($conn, $insertQueryProgram);
}

// Clear the success data session
unset($_SESSION['successData']);
mysqli_close($conn);

$_SESSION['updAlumniMess'] = ["Importing file successfully", "success"];
header("Location: ../alumni-directory.php");
exit(); // Ensure script termination after redirection
?>