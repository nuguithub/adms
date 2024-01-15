<?php
require_once 'connectDB.php';

function updateAccount($id, $achievement, $date)
{
    global $conn;

    // Validate date
    $selectedDate = new DateTime($date);
    $currentDate = new DateTime();

    if ($selectedDate > $currentDate) {
        echo "<script>alert('Date cannot be in the future.');
            setTimeout(function() {
            window.location.href = 'profile.php';
            }, 300); 
        </script>";
        return false;
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
            echo "<script>alert('Date cannot be before the batch year.');
                setTimeout(function() {
                window.location.href = 'profile.php';
                }, 300); 
            </script>";
            return false;
        }
    }

    $achievement = mysqli_real_escape_string($conn, $achievement);
    $date = mysqli_real_escape_string($conn, $date);

    $query = "INSERT INTO achievements (alumni_id, achievement, date) VALUES ('$id', '$achievement', '$date')";

    if (mysqli_query($conn, $query)) {
        return true; // Return true if the insertion was successful
    } else {
        echo "<script>alert('Failed to add achievement.');
        </script>";
        return false;
    }

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["addAchievement"])) {
    $id = $_POST['id'];
    $achievement = $_POST['achievement'];
    $date = $_POST['date'];

    if (updateAccount($id, $achievement, $date)) {
        echo "<script>alert('Achievement added successfully.');
            setTimeout(function() {
            window.location.href = 'profile.php';
            }, 300); 
        </script>";
    } 
}

$conn->close();
?>