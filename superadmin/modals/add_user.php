<style>
#eye,
#ceye {
    color: #ccc;
    transition: .3s ease;
}
</style>

<!-- Modal -->
<div class="modal fade" id="addUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="actions/adduser-act.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="role" class="d-flex ps-2" style="font-size: 12px;">User Type</label>
                        <select class="form-select" name="role_" required>
                            <option value="" disabled selected>User Type</option>
                            <option value="alumni_admin">Alumni Admin</option>
                            <option value="college_coordinator">College Coordinator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="d-flex ps-2" style="font-size: 12px;">Username</label>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                            name="username" required>

                    </div>
                    <div class="mb-3">
                        <label for="passwordx" class="d-flex ps-2" style="font-size: 12px;">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control z-0 rounded-2" placeholder="Password"
                                aria-label="Password" id="passx" name="passwordx" required>
                            <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="eye"
                                onclick="showPass('passx', 'eye')"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cpasswordx" class="d-flex ps-2" style="font-size: 12px;">Confirm
                            Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control z-0 rounded-2" placeholder="Confirm Password"
                                id="cpassx" aria-label="Confirm Password" name="cpasswordx" required>
                            <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1" id="ceye"
                                onclick="showPass('cpassx', 'ceye')"></i>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add User</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
</script>