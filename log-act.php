<?php
    
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkCredentials($username, $password)
{
    include 'connectDB.php';

    $stmt = $conn->prepare("SELECT user_id, passwordx, role_ FROM users WHERE username = ?");
    if (!$stmt) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        die("Error executing the statement: " . $stmt->error);
    }

    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password, $role_);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            if ($role_ === 'alumni') {
                $approved = "";

                $stmt = $conn->prepare("SELECT approved FROM alumni WHERE user_id = ?");
                if (!$stmt) {
                    die("Error in preparing the statement: " . $conn->error);
                }

                $stmt->bind_param("i", $user_id);
                if (!$stmt->execute()) {
                    die("Error executing the statement: " . $stmt->error);
                }

                $stmt->bind_result($approved);
                $stmt->fetch();
                $stmt->close();
                
                if ($approved === "approved") {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['role_'] = $role_;
                    return array("success" => true, "role_" => "alumni", "approved" => $approved);
                } else {
                    return array("success" => true, "role_" => "alumni", "" => $approved);
                }
            }
            else {
                if ($role_ === "college_coordinator") {
                    $college = "";

                    $stmt = $conn->prepare("SELECT college FROM users WHERE user_id = ?");
                    if (!$stmt) {
                        die("Error in preparing the statement: " . $conn->error);
                    }
    
                    $stmt->bind_param("i", $user_id);
                    if (!$stmt->execute()) {
                        die("Error executing the statement: " . $stmt->error);
                    }
    
                    $stmt->bind_result($college);
                    $stmt->fetch();
                    $stmt->close();
                    
                    $_SESSION['college'] = $college;
                }
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role_'] = $role_;
                return array("success" => true, "role_" => $role_); 
            }
        }
    } else {
        return array("success" => false);
    }
    
    $stmt->close();
    return array("success" => false);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo json_encode(array("success" => false));
        exit;
    }

    $result = checkCredentials($username, $password);

    echo json_encode($result);
}
?>