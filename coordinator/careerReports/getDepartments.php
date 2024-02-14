<?php
session_start();
$college = $_SESSION['college'];

include "../../connectDB.php";

$options = '';

// Use a prepared statement to prevent SQL injection
$sql = "SELECT * FROM departments WHERE dept_code = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $college);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch data if there's a result
    if ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . htmlspecialchars($row['dept_code']) . '">' . htmlspecialchars($row['dept_name']) . '</option>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

echo $options;
?>