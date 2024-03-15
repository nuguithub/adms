<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard.css">
    <title>Dashboard</title>
    <style>
    .nav-ln:nth-child(1)::after {
        opacity: 1;
    }
    </style>
</head>

<body>

    <?php 
        session_start();
        ob_start(); // Start output buffering
        include "connectDB.php";
        include "navbar.php";
        include "counter.php";
    ?>
    <div data-bs-spy="scroll" data-bs-target="#nav" data-bs-offset="0" data-bs-smooth-scroll="true" tabindex="0">
        <section class="z-0" id="carousel">
            <?php 
            include "carousel.php";
            ?>
        </section>
        <section id="announcements" class="container z-0 section-padding my-100" href="#Announcements">
            <?php
            include "ann-section.php"; 
            ?>
        </section>
        <section id="news" class="z-0">
            <?php
            include "news-section.php"; 
            ?>
        </section>
        <section id="reports" class="z-0">
            <?php
            include "reports.php"; 
            ?>
        </section>

    </div>
    <?php include "footer.php"; ?>
</body>
<script src="bootstrap/bs.js"></script>
<script src="bootstrap/popper.min.js"></script>

</html>