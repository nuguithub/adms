<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['student_number']) || !isset($_SESSION['department']) || !isset($_SESSION['course'])) {
    header("Location: register_step1.php");
    exit;
}
else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'connectDB.php';
    
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["passw"];
        $cpassword = $_POST["cpassw"];
    
        if (empty($username) || empty($password) || empty($cpassword)) {
            $error_message = "All fields are required.";
        } else {

            $sqlx = "SELECT COUNT(email) FROM users WHERE email = ?";
            $stmtx = $conn->prepare($sqlx);
            $stmtx->bind_param('s', $email); 
            $stmtx->execute();

            // Fetch the result
            $stmtx->bind_result($userCountx);
            $stmtx->fetch();

            if ($userCountx > 0) {
                echo "Email already exists. Please choose another email.";
            } else {
                // Close the first statement before preparing the second one
                $stmtx->close();

                if (strlen($username) >= 6 && strlen($username) <= 20) {
                
                    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
                    if (!$stmt) {
                        $error_message = "Invalid action.";
                    }
            
                    $stmt->bind_param("s", $username);
                    if (!$stmt->execute()) {
                        $error_message = "Invalid action.";
                    }
            
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        $error_message = "Username already taken. Please choose a different one.";
                    }
                    else {
                        if ($password != $cpassword) {
                            $error_message = "Passwords don't match.";
                        } else {
                            if (strlen($password) >= 8) {
                                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
                                $insert_user_query = "INSERT INTO users (username, email, passwordx) VALUES (?, ?, ?)";
                                $insert_user_stmt = $conn->prepare($insert_user_query);
                                if (!$insert_user_stmt) {
                                    $error_message = "Invalid action.";
                                }
                
                                $insert_user_stmt->bind_param("sss", $username, $email, $hashed_password);
                                if (!$insert_user_stmt->execute()) {
                                    $error_message = "Creating account failed.";
                                } else {
                                    $user_id = $insert_user_stmt->insert_id;
    
                                    // Update alumni
                                    $update_alumni_query = "UPDATE alumni SET user_id = ? WHERE student_number = ?";
                                    $update_alumni_stmt = $conn->prepare($update_alumni_query);
                                    
                                    if ($update_alumni_stmt) {
                                        $update_alumni_stmt->bind_param("ii", $user_id,  $_SESSION['student_number']);
                                        if (!$update_alumni_stmt->execute()) {
                                            $error_message = "Failed to update alumni.";
                                        }
                                    } else {
                                        $error_message = "Invalid action for alumni.";
                                    }
                                    
                                    // Update users
                                    $update_user_query = "UPDATE alumni SET email = ? WHERE user_id = ?";
                                    $update_user_stmt = $conn->prepare($update_user_query);
                                    
                                    if ($update_user_stmt) {
                                        $update_user_stmt->bind_param("si", $email, $user_id);
                                        if (!$update_user_stmt->execute()) {
                                            $error_message = "Failed to update user.";
                                        }
                                    } else {
                                        $error_message = "Invalid action for user.";
                                    }
                                    
                                    $conn->commit();
                                    header("Location: send_email.php?email=" . urlencode($email));
                                    session_unset();
                                    session_destroy();
                                }
                            } else {
                                $error_message = "8+ character password for enhanced security.";
                            }
                        }
                    }
                    $stmt->close();
                } else {
                    $error_message = "Username should have a minimum of 6 characters.";
                }
            }
        }
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 2</title>
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard.css">
    <style>
    .input-group .fas {
        color: #ccc;
    }

    input {
        border-radius: 0 !important;
    }

    input:focus {
        box-shadow: 0 0 #3330 !important;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php';?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="my-5 d-flex justify-content-center align-items-center">
                    <div class="card">
                        <div class="card-body m-5">
                            <div class="card-title">
                                <h3>Registration - Step 2</h3>
                            </div>
                            <hr>
                            <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" style="font-size: 14px;"
                                role="alert">
                                <?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <form action="register_step2.php" method="post">

                                <div class="mb-3">
                                    <label for="email" class="form-label fs-6 fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                    <div class="form-text text-secondary" style="font-size: 0.75rem;">
                                        Please ensure you provide a valid email address for confirmation.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label fs-6 fw-semibold">Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="passw" class="form-label fs-6 fw-semibold">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control z-0" id="passw-input" name="passw"
                                            required>
                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="eyex"
                                            onclick="showPass('passw-input', 'eyex')"></i>
                                    </div>
                                    <div class="form-text d-none" id="mess">Password is <span id="strength"></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="cpassw" class="form-label fs-6 fw-semibold">Confirm
                                        Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control z-0" id="cpassw-input" name="cpassw"
                                            required>
                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="ceye"
                                            onclick="showPass('cpassw-input', 'ceye')"></i>
                                    </div>
                                    <div class="form-text d-none" id="cmess">Password is <span id="cstrength"></span>
                                    </div>
                                </div>

                                <div class="text-center text-lg-end pt-3">
                                    <button type="submit" id="submit" class="btn btn-primary px-5">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/bs.js"></script>
    <script>
    // for show/hide Password
    function showPass(inputId, fasId) {
        const passwordInput = document.getElementById(inputId);
        const fas = document.getElementById(fasId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            fas.style.color = "green";
            fas.classList.remove("fa-eye");
            fas.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password"
            fas.style.color = "#ccc";
            fas.classList.remove("fa-eye-slash");
            fas.classList.add("fa-eye");
        }
    }

    // for Password strength
    function updatePasswordStrength(input, message, strength) {
        if (input.value.length > 0) {
            message.classList.remove("d-none");
        } else {
            message.classList.add("d-none");
        }
        if (input.value.length < 4) {
            strength.innerHTML = "weak";
            input.style.borderColor = "#FF3333";
            message.style.color = "#FF3333";
        } else if (input.value.length >= 4 && input.value.length < 8) {
            strength.innerHTML = "medium";
            input.style.borderColor = "#FFCC00";
            message.style.color = "#FFCC00";
        } else if (input.value.length >= 8) {
            strength.innerHTML = "strong";
            input.style.borderColor = "#00CC66";
            message.style.color = "#00CC66";
        }
    }

    var pass = document.getElementById("passw-input");
    var msg = document.getElementById("mess");
    var str = document.getElementById("strength");
    pass.addEventListener('input', () => {
        updatePasswordStrength(pass, msg, str);
    });

    var pass1 = document.getElementById("cpassw-input");
    var msg1 = document.getElementById("cmess");
    var str1 = document.getElementById("cstrength");
    pass1.addEventListener('input', () => {
        updatePasswordStrength(pass1, msg1, str1);
    });


    // for activeLink
    const registerLink = document.querySelector('.navbar-text .nav-item:last-child .nav-link');
    registerLink.classList.add('text-white', 'fw-semibold');
    window.removeEventListener('scroll', handleScroll);
    </script>

</body>

</html>