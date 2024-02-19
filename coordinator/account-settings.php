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
    #nav-list li:nth-child(7) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(7) a i,
    #nav-list li:nth-child(7) a span {
        color: var(--color-default);
    }

    label {
        font-size: 14px;
    }

    .input-group .fas {
        color: #ccc;
        transition: .5s ease;
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
                                        <p class="fw-bold p2">Username and Email</p>
                                        <div class="d-flex justify-content-between col-lg-8">
                                            <p>Your username is <span
                                                    class="fw-bold"><?php echo $_SESSION['username']; ?></span></p>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#changeUserModal">Change</a>
                                            <?php include 'actions/changeUsername.php'; ?>
                                            <?php
                                            require '../connectDB.php';
                                            $conn->set_charset("utf8");

                                            // Retrieve email from the database
                                            $query = "SELECT email FROM users WHERE username = ?";
                                            $stmt = $conn->prepare($query);
                                            $stmt->bind_param('s', $_SESSION['username']);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $emailResult = $result->fetch_assoc();
                                            $email = $emailResult ? $emailResult['email'] : NULL;

                                            // Display email and provide options
                                            ?>

                                        </div>
                                        <div class="d-flex justify-content-between col-lg-8">
                                            <p>Email address is <span
                                                    class="fw-bold"><?php echo ($email !== NULL) ? $email : 'not available'; ?></span>
                                            </p>
                                            <?php if ($email === NULL): ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#changeEmailModal">Add
                                                Email</a>
                                            <?php else: ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#changeEmailModal">Change
                                                Email</a>
                                            <?php endif; ?>
                                            <?php include 'actions/changeEmail.php'; ?>
                                        </div>
                                        <hr>


                                        <p class="fw-bold p2">Password</p>
                                        <div class="col-lg-8">
                                            <form name="changePass" action="actions/changePass.php" method="POST">
                                                <div class="">
                                                    <label for="currentPass" class="form-label">Current
                                                        Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control z-0 rounded-2"
                                                            id="currentPass" name="currentPass" required>
                                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1"
                                                            id="eye1" onclick="showPass('currentPass', 'eye1')"></i>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <label for="newPass" class="form-label">New
                                                        Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control z-0 rounded-2"
                                                            id="newPass" name="newPass" required>
                                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1"
                                                            id="eye2" onclick="showPass('newPass', 'eye2')"></i>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="confirmPass" class="form-label">Confirm
                                                        Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control z-0 rounded-2"
                                                            id="confirmPass" name="confirmPass" required>
                                                        <i class="fas fa-eye z-4 position-absolute end-0 pt-2 pe-3 mt-1"
                                                            id="eye3" onclick="showPass('confirmPass', 'eye3')"></i>
                                                    </div>
                                                </div>
                                                <input class="btn btn-primary mt-2 mb-3" type="submit" name="changePass"
                                                    value="Save Password">
                                            </form>
                                            <hr>
                                        </div>

                                        <div class="">
                                            <p class="fw-bold p2">Delete Account</p>
                                            <p style="font-size: 14px;" class="col-lg-4">
                                                Are you sure you want to delete your account?
                                                Deleting your account is a permanent and irreversible
                                                action. Deleting this account account will permanently
                                                remove your access and permissions. Please consider this
                                                decision carefully before proceeding.
                                            </p>
                                            <a href="#" style="font-size: 14px;" data-bs-toggle="modal"
                                                data-bs-target="#delAccountModal"
                                                class="fw-semibold text-danger pt-5 mt-5">I want to delete my
                                                account</a>
                                            <?php include 'actions/delAccount.php';?>
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
<script src="../assets/sidebar.js"></script>
<script src="../bootstrap/bs.js"></script>
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