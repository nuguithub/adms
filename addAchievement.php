<?php
session_start();
require_once 'connectDB.php';

function updateAccount($id, $achievement, $org, $date)
{
    global $conn;

    // Validate date
    $selectedDate = new DateTime($date);
    $currentDate = new DateTime();

    if ($selectedDate > $currentDate) {
        $_SESSION['educStat'] = ["Date cannot be in the future.", "danger"];
        header("Location: profile.php");
        exit();
    }

    // Assuming $batchYear is the batch year fetched from the database
    $batchYearQuery = "SELECT batch FROM alumni_program WHERE alumni_id = '$id'";
    $batchYearResult = mysqli_query($conn, $batchYearQuery);

    if ($batchYearResult) {
        $batchYearRow = mysqli_fetch_assoc($batchYearResult);
        $batchYear = $batchYearRow['batch'];

        // Extract the year part from the selected date
        $selectedYear = $selectedDate->format('Y');

        if ($selectedYear < $batchYear) {
            $_SESSION['educStat'] = ["Date cannot be before the batch year.", "danger"];
            header("Location: profile.php");
            exit();
        }
    }

    $achievement = mysqli_real_escape_string($conn, $achievement);
    $date = mysqli_real_escape_string($conn, $date);

    $query = "INSERT INTO achievements (alumni_id, achievement, org, date) VALUES ('$id', '$achievement', '$org', '$date')";

    if (mysqli_query($conn, $query)) {
        return true; // Return true if the insertion was successful
    } else {
        $_SESSION['educStat'] = ["Failed to add achievement.", "danger"];
        header("Location: profile.php");
        exit();
    }

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["addAchievement"])) {
    $id = $_POST['id'];
    $achievement = $_POST['achievement'];
    $org = $_POST['org'];
    $date = $_POST['date'];

    if (updateAccount($id, $achievement, $org, $date)) {
        $_SESSION['educStat'] = ["Achievement added successfully.", "success"];
    } 
}
header("Location: profile.php");
exit();
$conn->close();
?>