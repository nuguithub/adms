<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphical Reports</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../bootstrap/chart.js"></script>
    <style>
    #nav-list li:nth-child(7) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(7) a i,
    #nav-list li:nth-child(7) a span {
        color: var(--color-default);
    }

    .gg tbody tr td {
        background: transparent !important;
    }

    .form-select option {
        background: transparent !important;
    }
    </style>
</head>

<body>
    <main class="d-flex">
        <?php include "components/sidebar.php"; ?>

        <div class="home-section">
            <div class="card border-0 rounded-0 shadow-sm">
                <div class="container mt-3 mb-1">
                    <h1><strong>Reports</strong></h1>
                </div>
            </div>
            <div class="container">
                <!-- Site visits -->
                <?php include 'components/visitors.php';?>

                <!-- No. of alumni -->
                <?php include 'components/alumniNumber.php';?>

                <!-- Career -->
                <?php include 'components/careerReports.php';?>

            </div>
        </div>
    </main>

    <script src="../assets/sidebar.js"></script>
    <script src="../bootstrap/bs.js"></script>

</body>

</html>