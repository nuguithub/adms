<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Status</title>
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="vh-100 d-flex justify-content-center align-items-center">

    <div class="card border-0 shadow">
        <div class="card-body mx-4 py-5 px-3">
            <h1 class="fw-bolder">Status</h1>

            <?php
            if (isset($_SESSION['registerStat'])) {
                $registerStat = $_SESSION['registerStat'];

                $message = $registerStat[0];
                $alertType = $registerStat[1];

                echo '<div class="alert alert-' . $alertType . '" role="alert">';
                echo $message;
                echo '</div>';

                unset($_SESSION['registerStat']);
            } 
            ?>

            <div class="text-end d-flex align-items-center">
                <h2 class="pe-3">Redirecting</h2>
                <div class="spinner-border text-dark fs-3" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/bs.js"></script>
    <script>
    setTimeout(function() {
        window.location.href = 'dashboard.php';
    }, 3000); // 3000 milliseconds = 3 seconds
    </script>

</body>

</html>