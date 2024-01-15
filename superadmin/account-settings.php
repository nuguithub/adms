<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    label {
        font-size: 14px;
    }

    .input-group .fas {
        color: #ccc;
        transition: .5s ease;
    }

    #nav-list li:nth-child(3) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(3) a i,
    #nav-list li:nth-child(3) a span {
        color: var(--color-default);
    }

    .alert {
        font-size: 14px;
        padding: -20px;
    }
    </style>
</head>

<body>
    <main class="d-flex">

        <?php 
            include "components/sidebar.php";
        ?>

        <div class="home-section">

            <div class="container">
                <div class="d-flex flex-column">
                    <div class="col-lg-12">
                        <div class="my-3">
                            <div class="card overflow-auto" style="max-height: 90vh;">
                                <div class=" card-body m-3">
                                    <h3 class="card-title fw-bold my-3">Account Settings</h3>

                                    <?php
                                    
                                if(isset($_SESSION['user_stat'])) {
                                    if($_SESSION['user_stat'] === "A")
                                    { ?>

                                    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                                        Password changed successfully!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>

                                    <?php
                                        unset($_SESSION['user_stat']);
                                    }
                                    elseif($_SESSION['user_stat'] === "C")
                                    { ?>

                                    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                                        Username changed successfully!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>

                                    <?php
                                            unset($_SESSION['user_stat']);
                                    }
                                    else { ?>


                                    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                                        <?php echo $_SESSION['user_stat']; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>

                                    <?php
                                            unset($_SESSION['user_stat']);
                                    }
                                }
                                ?>

                                    <div class="my-3">
                                        <p class="fw-bold p2">Username</p>
                                        <div class="d-flex justify-content-between col-lg-8">
                                            <p>Your username is <span
                                                    class="fw-bold"><?php echo $_SESSION['username']; ?></span></p>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#changeUserModal">Change</a>
                                            <?php include 'modals/changeUsername.php';?>
                                        </div>
                                        <hr>

                                        <p class="fw-bold p2">Password</p>
                                        <div class="col-lg-8">
                                            <form name="changePass" action="actions/changePass.php" method="POST">
                                                <div class="">
                                                    <label for="currentPass" class="form-label">Current
                                                        Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control z-0 rounded-1"
                                                            id="currentPass" name="currentPass" required>
                                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1"
                                                            id="eye1" onclick="showPass('currentPass', 'eye1')"></i>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <label for="newPass" class="form-label">New
                                                        Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control z-0 rounded-1"
                                                            id="newPass" name="newPass" required>
                                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1"
                                                            id="eye2" onclick="showPass('newPass', 'eye2')"></i>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="confirmPass" class="form-label">Confirm
                                                        Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control z-0 rounded-1"
                                                            id="confirmPass" name="confirmPass" required>
                                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1"
                                                            id="eye3" onclick="showPass('confirmPass', 'eye3')"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;">Can't remember your current password? <a
                                                        href="#" data-bs-toggle="modal"
                                                        data-bs-target="#forgotPassModal">Forgot Password</a>
                                                </p>
                                                <input class="btn btn-primary mt-2" type="submit" name="changePass"
                                                    value="Save Password">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
<script src="../bootstrap/bs.js"></script>
<script src="../assets/sidebar.js"></script>
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

</html>