<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link rel="icon" type="image/x-icon" href="../../img/favicon.png">
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
                <h3 class="my-3 fw-bolder">
                    Forgot Password
                </h3>
                <?php
                    if(!empty($_SESSION['mess123'])) {
                        echo $_SESSION['mess123'];
                        unset($_SESSION['mess123']);
                    }
                ?>

                <form method="post" action="send-password-reset.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5">Send</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
<script src="../../bootstrap/bs.js"></script>

</html>