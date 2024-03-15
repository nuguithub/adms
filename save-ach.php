<?php
    session_start();
    include './connectDB.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveAch'])) {
        // Retrieve form data
        $achievement = $_POST['achievement'];
        $org = $_POST['org'];
        $date = $_POST['date'];
        $id = $_POST['id'];

        // Use prepared statement for the UPDATE query
        $sqlUpdateAch = "UPDATE achievements SET achievement = ?, org = ?, date = ? WHERE id = ?";
        $stmtUpdateAch = mysqli_prepare($conn, $sqlUpdateAch);

        if ($stmtUpdateAch) {
            mysqli_stmt_bind_param($stmtUpdateAch, "sssi", $achievement, $org, $date, $id);

            if (mysqli_stmt_execute($stmtUpdateAch)) {
                $_SESSION['educStat'] = ["Achievement updated successfully.", "success"];
            } else {
                $_SESSION['educStat'] = ["Error updating achievement.", "danger"];
            }

            mysqli_stmt_close($stmtUpdateAch);
        } else {
            $_SESSION['educStat'] = ["Error preparing statement.", "danger"];
        }
    }

    header("Location: profile.php");
    exit();

    mysqli_close($conn);

?>