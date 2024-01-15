<?php
require_once 'connectDB.php';

function updateAccount($id, $address, $email, $contactNumber)
{
    global $conn;

    $address = mysqli_real_escape_string($conn, $address);
    $email = mysqli_real_escape_string($conn, $email);
    $contactNumber = mysqli_real_escape_string($conn, $contactNumber);

    $getUser = "SELECT user_id FROM alumni WHERE alumni_id = '$id'";
    $userResult = $conn->query($getUser);
    if ($userResult && $userResult->num_rows > 0) {
        $user_id = $userResult->fetch_assoc()['user_id'];
    }


    $sql = "UPDATE alumni AS a
                INNER JOIN users AS u ON a.user_id = u.user_id
                SET 
                a.address_ = " . (!empty($address) ? "'$address'" : "NULL") . ",
                a.email = " . (!empty($email) ? "'$email'" : "NULL") . ",
                contact_no = " . (!empty($contactNumber) ? "'+63$contactNumber'" : "NULL") . ",
                u.email = " . (!empty($email) ? "'$email'" : "NULL") . "
                WHERE a.alumni_id = '$id' AND u.user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
            return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editContact"])) {
    $id = $_POST['id'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];

    if (updateAccount($id, $address, $email, $contactNumber)) {
        echo "<script>alert('Contact updated successfully.');
            setTimeout(function() {
            window.location.href = 'profile.php';
            }, 300); 
        </script>";
    } else {
        echo "<script>alert('Failed to update contacts.');
            setTimeout(function() {
            window.location.href = 'profile.php';
            }, 300); 
        </script>";
    }
}

$conn->close();
?>