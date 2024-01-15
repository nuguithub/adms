<?php
require_once('../connectDB.php');

$query = "SELECT dept_code, dept_name FROM departments";

$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();

$departments = [];
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');

echo json_encode($departments);
?>