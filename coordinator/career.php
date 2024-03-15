<?php
include_once '../connectDB.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Alumni</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    #nav-list li:nth-child(4) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(4) a i,
    #nav-list li:nth-child(4) a span {
        color: var(--color-default);
    }

    .card {
        position: relative;
        overflow: hidden;
        border: 1px solid #18181a;
        color: #18181a;
        font-size: 15px;
        padding: 18px 18px 17px;
        text-decoration: none;
        cursor: pointer;
        background: #fff;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        height: 6rem;
    }

    .card span:first-child {
        position: relative;
        transition: color 600ms cubic-bezier(0.48, 0, 0.12, 1);
        z-index: 10;
    }

    .card span:last-child {
        color: white;
        display: block;
        position: absolute;
        bottom: 0;
        transition: all 500ms cubic-bezier(0.48, 0, 0.12, 1);
        z-index: 100;
        opacity: 0;
        top: 50%;
        left: 50%;
        transform: translateY(225%) translateX(-50%);
        height: 14px;
        line-height: 13px;
    }

    .card:after {
        content: "";
        position: absolute;
        bottom: -150%;
        left: 0;
        width: 150%;
        height: 150%;
        background-color: black;
        transform-origin: bottom center;
        transition: transform 600ms cubic-bezier(0.48, 0, 0.12, 1);
        transform: skewY(9.3deg) scaleY(0);
        z-index: 50;
    }

    .card:hover:after {
        transform-origin: bottom center;
        transform: skewY(9.3deg) scaleY(2);
    }

    .card:hover span:last-child {
        transform: translateX(-50%) translateY(-100%);
        opacity: 1;
        transition: all 900ms cubic-bezier(0.48, 0, 0.12, 1);
    }
    </style>
</head>

<body>
    <main class="d-flex overflow-hidden">

        <?php include "components/sidebar.php"; ?>

        <div class="home-section">
            <div class="row">
                <div class="col-lg-12 my-5 px-5">
                    <h3 class="pb-3 fw-bold">Careers - Courses</h3>
                    <?php
                        if (isset($_SESSION['careerMess'])) {
                            $message = $_SESSION['careerMess'][0];
                            $alertType = $_SESSION['careerMess'][1];
                            unset($_SESSION['careerMess']); 
                        ?>

                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <?php
                        }
                        ?>

                    <div class="">
                        <div class="row text-center my-3">

                            <?php
                            // Include database connection
                            include_once '../connectDB.php';

                            // Query to fetch courses from the database
                            $query = "SELECT departments.dept_code, courses.*
                                FROM courses
                                LEFT JOIN departments
                                ON departments.dept_id = courses.department_id
                                WHERE dept_code = '$college' ";
                            $result = $conn->query($query);

                            // Check if there are any courses
                            if ($result->num_rows > 0) {
                                // Loop through each courses and display a card
                                while ($row = $result->fetch_assoc()) { ?>

                            <div class="col-12 col-lg-6 mb-2">
                                <a href="careerx.php?course_code=<?php echo $row['course_code']; ?>"
                                    class="text-decoration-none">
                                    <div class="card shadow w-100">
                                        <div class="card-body ">
                                            <span class="card-title d-flex align-middle justify-content-center">
                                                <?php echo $row['course_name']; ?></span>
                                            <span class="card-title d-flex align-middle justify-content-center fw-bold">
                                                <?php echo $row['course_code']; ?> Careers</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <?php
                                }
                            } else {
                                // Display a message if no records are found
                                echo '<div class="col-12 my-3 text-center">No records found.</div>';
                            }
                            $conn->close();
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="../assets/sidebar.js"></script>
    <script src="../bootstrap/bs.js"></script>
</body>

</html>