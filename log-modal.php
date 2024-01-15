<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
#eye {
    color: #ccc;
}

.form-label {
    font-size: 14px;
    margin-left: 10px;
}

#loginBtn {
    background-color: #008000;
    color: #ffffff;
}

#loginBtn:hover {
    background-color: #005000;
}
</style>
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog position-absolute top-50 start-50 translate-middle">
        <div class="modal-content">
            <div class="modal-body">
                <div style="width: 20rem;">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="modal-title fw-bolder" id="loginModalLabel" style="color: #008000;">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="error-message" class="alert alert-danger w-100 d-none" style="font-size: 14px;"></div>
                    <form id="loginForm" action="log-act.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label text-secondary">Username</label>
                            <input type="text" class="form-control rounded-3" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="passw" class="form-label text-secondary">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control rounded-3 z-0" id="passw" name="password">
                                <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="eye"></i>
                            </div>
                        </div>
                        <a href="assets/resetpass/forgot-password.php" style="font-size:14px;color: #005000;">Forgot
                            Password?</a>
                        <div class="text-end pt-3 mt-4">
                            <button type="button" name="loginBtn" id="loginBtn"
                                class="btn rounded-3 w-100 fw-bolder">Login</button>
                        </div>
                    </form>
                </div>
            </div>
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


function validateLoginForm() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("passw").value;
    const errorMessage = document.getElementById("error-message");

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const response = JSON.parse(this.responseText);

            if (response.success) {
                if (response.role_ === "alumni_admin") {
                    setTimeout(function() {
                        window.location.href = 'admin/admin-dashboard.php';
                    }, 500);
                } else if (response.role_ === "super_admin") {
                    setTimeout(function() {
                        window.location.href = "superadmin/superadmin-dashboard.php";
                    }, 500);
                } else if (response.role_ === "college_coordinator") {
                    setTimeout(function() {
                        window.location.href = "coordinator/coor-dashboard.php";
                    }, 500);
                } else if (response.role_ === "alumni") {
                    if (response.approved === "approved") {
                        setTimeout(function() {
                            window.location.href = "alum-dashboard.php";
                        }, 500);
                    } else {
                        errorMessage.textContent = "Your account is not yet approved by the coordinator";
                        errorMessage.classList.remove("d-none");
                    }
                }
            } else {
                errorMessage.textContent = "Invalid username or password";
                errorMessage.classList.remove("d-none");
            }
        }
    };
    xhttp.open("POST", "log-act.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
}

document.getElementById("loginBtn").addEventListener("click", validateLoginForm);

document.getElementById('loginForm').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('loginBtn').click();
    }
});
</script>