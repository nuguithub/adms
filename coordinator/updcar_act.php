<?php
include_once '../connectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $careerId = $_POST['career_id'];
    $updatedCareerName = $_POST['career_name'];

    $updateQuery = "UPDATE careers SET career_name = ? WHERE career_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $updatedCareerName, $careerId);

    if ($stmt->execute()) {
        // not working if doesn't have this
    } 

    $stmt->close();
    $conn->close();
} 
?>