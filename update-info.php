<?php
require_once 'connectDB.php';

function updateAccount($id, $fname, $mname, $lname, $gender, $civilStat, $birthday)
{
    global $conn;

    $fname = mysqli_real_escape_string($conn, $fname);
    $mname = mysqli_real_escape_string($conn, $mname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $gender = mysqli_real_escape_string($conn, $gender);
    $birthday = mysqli_real_escape_string($conn, $birthday);
    $civilStat = mysqli_real_escape_string($conn, $civilStat);

    $currentDate = date('Y-m-d');
    if ($birthday > $currentDate) {
        return false;
    }

    $getUser = "SELECT user_id FROM alumni WHERE alumni_id = '$id'";
    $userResult = $conn->query($getUser);
    if ($userResult && $userResult->num_rows > 0) {
        $user_id = $userResult->fetch_assoc()['user_id'];
    }

    $sql = "UPDATE alumni SET 
        fname = '$fname',
        mname = '$mname',
        lname = '$lname',
        gender = '$gender',
        civil_status = " . (!empty($civilStat) ? "'$civilStat'" : "NULL") . ",
        birthday = " . (!empty($birthday) ? "'$birthday'" : "NULL") . "
        WHERE alumni_id = '$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editInfo"])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $civilStat = $_POST['civilStat'];

    if (updateAccount($id, $fname, $mname, $lname, $gender, $civilStat, $birthday)) {
        echo "<script>alert('Account updated successfully.');
            setTimeout(function() {
            window.location.href = 'profile.php';
            }, 300); 
        </script>";
    } else {
        echo "<script>alert('Failed to update account or invalid birthday.');
            setTimeout(function() {
            window.location.href = 'profile.php';
            }, 300); 
        </script>";
    }
}

$conn->close();
?>