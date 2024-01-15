<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../../connectDB.php';
require 'verify.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle password reset
    $email = $_POST["email"];
    $token = $_POST["token"];

    $sql = "SELECT * FROM users WHERE email = ? AND token = ? AND token_expiry > date('Y-m-d H:i:s')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $password = $_POST["pass"];

        if (strlen($password) < 8) {
            $reset_prompt = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password must be at least 8 characters.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

        } elseif (!preg_match("/[a-z]/i", $password)) {
            $reset_prompt = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password must contain at least one letter.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

        } elseif (!preg_match("/[0-9]/", $password)) {
            $reset_prompt = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password must contain at least one number.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

        } elseif ($_POST["pass"] !== $_POST["cpass"]) {
            $reset_prompt = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Passwords don`t match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $reset = $conn->prepare("UPDATE users SET passwordx = ?, token = NULL, token_expiry = NULL WHERE email = ?");
            $reset->bind_param('ss', $password_hash, $email);
            $reset->execute();

            $_SESSION['mess123'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Password updated. You can now login.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

            header("Location: forgot-password.php");
            exit;
        }
        
    } else {
        $reset_prompt = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Token not found or expired.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../bootstrap/bs.css">
    <link rel="stylesheet" href="../dashboard.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
</head>

<body>
    <?php include 'navbar.php';?>
    <div class="container mt-5">
        <div class="card mx-auto w-75">
            <div class="card-body">

                <h3 class="my-3 fw-bolder">Reset Password</h3>

                <?php if (isset($reset_prompt)) echo $reset_prompt; ?>
                <form method="post">
                    <input type="hidden" name="token" value="<?php echo $hash_token; ?>" />
                    <input type="hidden" name="email" class="form-control" value="<?php echo $email; ?>" />

                    <label for="pass" class="form-label">New Password</label>
                    <div class="input-group mb-3">
                        <input type="password" name="pass" class="form-control rounded-3 z-0" id="pw">
                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="pw-" style="color: #ccc;"
                            onclick="showPassx('pw', 'pw-')"></i>
                    </div>

                    <label for="cpass" class="form-label">Confirm Password</label>
                    <div class="input-group mb-3">
                        <input type="password" name="cpass" class="form-control rounded-3 z-0" id="cpw">
                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="cpw-" style="color: #ccc;"
                            onclick="showPassx('cpw', 'cpw-')"></i>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="../../bootstrap/bs.js"></script>
<script>
function showPassx(inputId, fasId) {
    const passwordInput = document.getElementById(inputId);
    const fas = document.getElementById(fasId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        fas.style.color = "green";
        fas.classList.remove("fa-eye");
        fas.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        fas.style.color = "#ccc"; // Fixed the syntax here
        fas.classList.remove("fa-eye-slash");
        fas.classList.add("fa-eye");
    }
}
</script>


</html>