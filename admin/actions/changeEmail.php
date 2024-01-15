<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../connectDB.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changeEmail"])) {
    $newEmail = $_POST["newEmail"];
    $passx = $_POST["password"];
    
    global $conn;

    $newEmail = mysqli_real_escape_string($conn, $newEmail);
    $passx = mysqli_real_escape_string($conn, $passx);

    $sqlEmail = "SELECT * FROM users WHERE username= ?";
    $stmtEmail = $conn->prepare($sqlEmail);
    $stmtEmail->bind_param('s', $_SESSION["username"]);
    $stmtEmail->execute();
    $resultEmail = $stmtEmail->get_result();
    $rowEmail = $resultEmail->fetch_assoc();

    if (!empty($rowEmail)) {
        
        $hashedPassword = $rowEmail["passwordx"];
            
        if (password_verify($passx, $hashedPassword)) {
            if ($newEmail != $_SESSION["username"]) {

                $sqlEmail = "UPDATE users SET email = ? WHERE user_id=?";
                $stmtEmail = $conn->prepare($sqlEmail);
                $stmtEmail->bind_param('si', $newEmail, $rowEmail["user_id"]);
                $stmtEmail->execute();
                
                $_SESSION['user_stat'] = "C";
                echo "
                <script>
                    window.location.href = 'account-settings.php'; 
                </script>";
            } else {
                $_SESSION['user_stat'] = "Email doesn't change.";
                echo "
                <script>
                    window.location.href = 'account-settings.php'; 
                </script>";
            }
        } else {
            $_SESSION['user_stat'] = "Incorrect password.";
            echo "
            <script>
                window.location.href = 'account-settings.php'; 
            </script>";
        }
    }
}

$conn->close();
?>

<div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="changeEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changeEmailModalLabel"><strong>Change Email</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form name="changeEmail" method="POST">
                <div class="modal-body">
                    <div class="">
                        <label for="">Current Email</label>
                        <input type="text" class="form-control"
                            value="<?php echo ($email !== NULL) ? $email :'not available'; ?>" disabled>
                    </div>

                    <div class="">
                        <label for="username">New Email</label>
                        <input type="email" class="form-control" name="newEmail" required>
                    </div>

                    <div class="">
                        <label for="">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control rounded-2 z-0" id="hudyat" name="password">
                            <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="mata"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="changeEmail" value="Save changes"></input>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
let mata = document.getElementById("mata");
let hudyat = document.getElementById("hudyat");

mata.onclick = function() {
    if (hudyat.type == "password") {
        hudyat.type = "text";
        mata.style.color = "green";
        mata.classList.remove("fa-eye");
        mata.classList.add("fa-eye-slash");
    } else {
        hudyat.type = "password"
        mata.style.color = "#ccc";
        mata.classList.remove("fa-eye-slash");
        mata.classList.add("fa-eye");
    }

}
</script>