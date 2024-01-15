<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username'])) {

    include '../connectDB.php';
    
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $userId = $row['user_id'];
        $pass = $row['passwordx'];

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delAcc"])) {

            $password = $_POST['password'];
            $password = mysqli_real_escape_string($conn, $password);
            
            if(password_verify($password, $pass)) {
                $deleteSql = "DELETE FROM users WHERE username = '$username'";
                $result = $conn->query($deleteSql);

                if ($result === TRUE) {
                    echo "<script>
                        alert('Your account has been deleted');
                        window.location.href = '../logout-act.php'; 
                    </script>";
                    exit;
                } else {
                    $_SESSION['user_stat'] = "Account deletion failed.";
                    echo "<script>
                        window.location.href = 'account-settings.php'; 
                    </script>";
                }

                
            }
            else {
                $_SESSION['user_stat'] = "Incorrect password.";
                echo "<script>
                    window.location.href = 'account-settings.php'; 
                </script>";
            }
        }
    } else{
        $_SESSION['user_stat'] = "User not found.";
        echo "
        <script>
            window.location.href = 'account-settings.php'; 
        </script>";
    }

    
}
?>

<div class="modal fade" id="delAccountModal" tabindex="-1" aria-labelledby="delAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="delAccountModalLabel"><strong>Delete Account?</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form name="delAccount" method="POST">
                <div class="modal-body">
                    <p>Account deletion is final. There will be no way to restore your account.
                    </p>
                    <hr>
                    <div class="">
                        <label for="">Enter Password for Confirmation</label>
                        <div class="input-group">
                            <input type="password" class="form-control z-0 rounded-1" id="passw4" name="password">
                            <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="eye4"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" name="delAcc" value="Delete Account"></input>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
let eye4 = document.getElementById("eye4");
let passw4 = document.getElementById("passw4");

eye4.onclick = function() {
    if (passw4.type == "password") {
        passw4.type = "text";
        eye4.style.color = "green";
        eye4.classList.remove("fa-eye");
        eye4.classList.add("fa-eye-slash");
    } else {
        passw4.type = "password"
        eye4.style.color = "#ccc";
        eye4.classList.remove("fa-eye-slash");
        eye4.classList.add("fa-eye");
    }

}
</script>