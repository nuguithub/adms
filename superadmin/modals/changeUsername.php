<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../connectDB.php';


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changeUsername"])) {
    $newUser= $_POST["newUser"];
    $passx = $_POST["password"];
    global $conn;

    $newUser = mysqli_real_escape_string($conn, $newUser);
    $passx = mysqli_real_escape_string($conn, $passx);

    $sql = "SELECT * FROM users WHERE username= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!empty($row)) {
        
        $hashedPassword = $row["passwordx"];
            
        if (password_verify($passx, $hashedPassword)) {
            if ($newUser != $_SESSION["username"]) {

                $sql = "UPDATE users SET username=? WHERE user_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $newUser, $row["user_id"]);
                $stmt->execute();
                
                $_SESSION['user_stat'] = "C";
                unset($_SESSION['username']);
                $_SESSION['username'] = $newUser;
                echo "
                <script>
                    window.location.href = 'account-settings.php'; 
                </script>";
            } else {
                $_SESSION['user_stat'] = "Username doesn't change.";
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

<div class="modal fade" id="changeUserModal" tabindex="-1" aria-labelledby="changeUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changeUserModalLabel"><strong>Change Username</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form name="changeUsername" method="POST">
                <div class="modal-body">
                    <div class="">
                        <label for="">Current Username</label>
                        <input type="text" class="form-control" value="<?php echo $_SESSION['username'];?>" disabled>
                    </div>

                    <div class="">
                        <label for="username">New Username</label>
                        <input type="text" class="form-control" name="newUser">
                    </div>

                    <div class="">
                        <label for="">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control z-0 rounded-1" id="passw" name="password">
                            <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="eye"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="changeUsername" value="Save changes"></input>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
let eye = document.getElementById("eye");
let passw = document.getElementById("passw");

eye.onclick = function() {
    if (passw.type == "password") {
        passw.type = "text";
        eye.style.color = "green";
        eye.classList.remove("fa-eye");
        eye.classList.add("fa-eye-slash");
    } else {
        passw.type = "password"
        eye.style.color = "#ccc";
        eye.classList.remove("fa-eye-slash");
        eye.classList.add("fa-eye");
    }

}
</script>