<?php
include '../../connectDB.php';

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Update status using MySQLi
    $query = "UPDATE alumni SET approved = 'approved' WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Retrieve email using MySQLi
    $sql = "SELECT email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Access the email
    $email = $row['email'];
    header("Location: emailApproved.php?email=" . urlencode($email));
    
} else {
    echo "<script>alert('Failed to update status');
         setTimeout(function() {
                window.location.href = '../alumni.php';
        }, 200);</script>";
}
?>