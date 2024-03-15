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
                unset($_SESSION['email']);
            } else {
                // Close the first statement before preparing the second one
                $_SESSION['email'] = $email;
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
                        unset($_SESSION['username']);
                    }
                    else {
                        $_SESSION['username'] = $username;
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
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
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

    .form-text,
    #strength,
    #cstrength {
        font-size: .75rem;
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
                                    <input type="email" class="form-control" name="email" id="emailx"
                                        value="<?php echo $_SESSION['email'] ?? ''; ?>" required>
                                    <div class="form-text text-secondary">
                                        Please ensure you provide a valid email address for confirmation.
                                    </div>
                                    <div class="form-text d-none" id="emess"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label fs-6 fw-semibold">Username</label>
                                    <input type="text" class="form-control" name="username" id="uname"
                                        value="<?php echo $_SESSION['username'] ?? ''; ?>" required>
                                    <div class="form-text d-none" id="umess"></div>
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
                                    <label for="cpassw" class="form-label fs-6 fw-semibold">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control z-0" id="cpassw-input" name="cpassw"
                                            required>
                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="ceye"
                                            onclick="showPass('cpassw-input', 'ceye')"></i>
                                    </div>
                                    <div class="form-text d-none" id="cmess"></div>
                                </div>

                                <div class="text-center text-lg-end">
                                    <button type="submit" id="regButton" class="btn btn-primary px-5 mt-3"
                                        disabled>Register</button>
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
    // Function to show/hide Password
    function showPass(inputId, fasId) {
        const passwordInput = document.getElementById(inputId);
        const fas = document.getElementById(fasId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            fas.style.color = "green";
            fas.classList.remove("fa-eye");
            fas.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            fas.style.color = "#ccc";
            fas.classList.remove("fa-eye-slash");
            fas.classList.add("fa-eye");
        }
    }

    // Function to update Password strength
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

    // Event listeners for password and confirm password inputs
    const pass = document.getElementById("passw-input");
    const msg = document.getElementById("mess");
    const str = document.getElementById("strength");

    pass.addEventListener('input', () => {
        updatePasswordStrength(pass, msg, str);
    });

    let emailCheck = false;
    let userCheck = false;
    let passCheck = false;

    function updateEmail(input, messagex) {
        if (messagex.innerHTML.trim().length > 0) {
            messagex.classList.remove("d-none");
        } else {
            messagex.classList.add("d-none");
        }

        // Use a regular expression to check for a valid email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailRegex.test(input.value)) {
            messagex.innerHTML = "";
            input.style.borderColor = "#00CC66";
            messagex.style.color = "#00CC66";
            emailCheck = true;
        } else {
            messagex.innerHTML = "Invalid Email Format";
            input.style.borderColor = "#FF3333";
            messagex.style.color = "#FF3333";
            emailCheck = false;
        }
    }

    // Event listeners for email input
    const emailInput = document.querySelector('[name="email"]');
    const emailMessage = document.getElementById("emess");

    emailInput.addEventListener('input', () => {
        updateEmail(emailInput, emailMessage);
    });


    function updateUser(input, messagex) {
        if (messagex.innerHTML.trim().length > 0) {
            messagex.classList.remove("d-none");
        } else {
            messagex.classList.add("d-none");
        }

        // Use a regular expression to check for only alphanumeric characters without spaces
        const alphanumericRegex = /^[a-zA-Z0-9]+$/;

        if (input.value.length > 5 && alphanumericRegex.test(input.value)) {
            messagex.innerHTML = "";
            input.style.borderColor = "#00CC66";
            messagex.style.color = "#00CC66";
            userCheck = true;
        } else {
            messagex.innerHTML = "Weak Username. Avoid spaces and special characters.";
            input.style.borderColor = "#FF3333";
            messagex.style.color = "#FF3333";
            userCheck = false;
        }
    }

    // Event listeners for username input
    const userx = document.getElementById("uname");
    const messx = document.getElementById("umess");

    userx.addEventListener('input', () => {
        updateUser(userx, messx);
    });


    function checkPasswordMatch(pass, confirm, cmess) {
        if (confirm.value.length > 0 && pass.value.length >= 8) {
            if (pass.value !== confirm.value) {
                cmess.classList.remove("d-none");
                confirm.style.borderColor = "#FF3333";
                cmess.style.color = "#FF3333";
                cmess.innerHTML = "Passwords don't match.";
                passCheck = false;
            } else {
                cmess.classList.add("d-none");
                confirm.style.borderColor = "#00CC66";
                passCheck = true;
            }
        } else {
            confirm.style.borderColor = "";
            cmess.innerHTML = "";
            passCheck = false;
        }
    }

    const pass1 = document.getElementById("passw-input");
    const cpass = document.getElementById("cpassw-input");
    const cmess = document.getElementById("cmess");

    cpass.addEventListener('input', () => {
        checkPasswordMatch(pass1, cpass, cmess);
    });

    pass1.addEventListener('input', () => {
        checkPasswordMatch(pass1, cpass, cmess);
    });

    function validateAndToggleRegistrationButton() {
        if (emailCheck === true && userCheck === true && passCheck === true) {
            const regButton = document.getElementById("regButton");
            regButton.disabled = false;
            console.log("TANGINA");
        } else {
            console.log("GAGO");
            regButton.disabled = true;
        }
    }

    // Event listeners for email, username, and password inputs
    const email = document.getElementById("emailx");
    const usery = document.getElementById("uname");
    const pass2 = document.getElementById("passw-input");
    const cpasx = document.getElementById("cpassw-input");

    emailInput.addEventListener('input', () => {
        updateEmail(emailInput, document.getElementById("emess"));
        validateAndToggleRegistrationButton();
    });

    usery.addEventListener('input', () => {
        updateUser(userx, document.getElementById("umess"));
        validateAndToggleRegistrationButton();
    });

    cpasx.addEventListener('input', () => {
        checkPasswordMatch(pass1, cpass, document.getElementById("cmess"));
        validateAndToggleRegistrationButton();
    });

    pass2.addEventListener('input', () => {
        checkPasswordMatch(pass1, cpass, document.getElementById("cmess"));
        validateAndToggleRegistrationButton();
    });
    </script>

</body>

</html>