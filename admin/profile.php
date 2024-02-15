<?php
include '../connectDB.php';

if(isset($_GET['student_number'])) {
    $studentNumber = $_GET['student_number'];

    $currentWork = '';

    // Fetch alumni data
    $alumniQuery = "SELECT * FROM alumni WHERE student_number = ?";
    $alumniStmt = mysqli_prepare($conn, $alumniQuery);

    if ($alumniStmt) {
        mysqli_stmt_bind_param($alumniStmt, "s", $studentNumber);
        mysqli_stmt_execute($alumniStmt);

        $alumniResult = mysqli_stmt_get_result($alumniStmt);
        $alumniData = mysqli_fetch_assoc($alumniResult);

        $fullName = $alumniData['fname'] . ' ' . $alumniData['mname']. ' ' . $alumniData['lname'];

        mysqli_stmt_close($alumniStmt);
    }

    // Fetch alumni program data
    $programQuery = "SELECT alumni_program.*, courses.course_name 
                 FROM alumni_program 
                 INNER JOIN courses ON alumni_program.coll_course = courses.course_code
                 WHERE alumni_program.alumni_id = ?";
    $programStmt = mysqli_prepare($conn, $programQuery);

    if ($programStmt && isset($alumniData['alumni_id'])) {
        mysqli_stmt_bind_param($programStmt, "i", $alumniData['alumni_id']);
        mysqli_stmt_execute($programStmt);

        $programResult = mysqli_stmt_get_result($programStmt);
        $programData = mysqli_fetch_assoc($programResult);

        mysqli_stmt_close($programStmt);
    }

    $workHistoryQuery = "SELECT * FROM workHistory WHERE user_id = ? ORDER BY workEnd DESC";
    $workHistoryStmt = mysqli_prepare($conn, $workHistoryQuery);

    if ($workHistoryStmt && isset($alumniData['user_id'])) {

        $currentWorkQuery = "SELECT position FROM workHistory WHERE workEnd = 'Present'";
        $cwResult = $conn->query($currentWorkQuery);

        if ($row = $cwResult->fetch_assoc()) {
            $currentWork = $row['position'];
        }

        mysqli_stmt_close($workHistoryStmt);
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fullName;?></title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='../assets/alumniProfile.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body class="vh-100">
    <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid d-flex justify-content-between px-md-5" id="nav">
            <a class="navbar-brand" href="../dashboard.php">ADMS</a>
            <a class="nav-item nav-link text-light" href="alumni-directory.php">Dashboard</a>
        </div>
    </nav>

    <section id="resume" class="resume">
        <div class="container m-5 mx-auto">
            <div class="">
                <div class="row d-lg-flex d-block align-items-center">
                    <div class="col-lg-4 col-12">
                        <?php
                            if (!empty($alumniData['img'])) {
                        ?>
                        <div class="text-center">
                            <img src="../img/alumni/<?php echo $alumniData['img']; ?>" alt="Profile Pic"
                                class="rounded-circle object-fit-cover mb-3 mb-lg-0" width="180" height="180">
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="text-center">
                            <img src="../img/alumni/no-image.png" alt="Profile Pic"
                                class="rounded-circle object-fit-cover mb-3 mb-lg-0" width="180" height="180">
                        </div>

                        <?php
                            }
                        ?>
                    </div>
                    <div class="col-lg-8 col-12">
                        <div class="w-100 text-center text-lg-start">
                            <h1 class="mt-lg-5 mb-0 fw-bolder fname">
                                <?php echo $fullName;  ?>
                            </h1>
                            <h3 class="fw-light mb-0 work"><?php echo $currentWork;  ?></h3>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 ms-3 ms-lg-0" data-aos="fade-up">
                    <h3 class="resume-title">Personal Information</h3>
                    <div class="resume-item pb-0">
                        <h4>CONTACT</h4>
                        <div class="ms-4">
                            <p class="d-flex align-items-center">
                                <i class='bx bxs-map fs-4 me-2'></i><span>
                                    <?php echo $alumniData['address_'] ?? '<em class="text-secondary">Unavailable</em>'; ?>
                                </span>
                            </p>
                            <p class="d-flex align-items-center">
                                <i class='bx bxs-phone fs-4 me-2'></i><span>
                                    <?php echo $alumniData['contact_no'] ?? '<em class="text-secondary">Unavailable</em>'; ?>
                            </p>
                            <p class="d-flex align-items-center">
                                <i class='bx bxs-envelope fs-4 me-2'></i><span>
                                    <?php echo $alumniData['email'] ?? '<em class="text-secondary">Unavailable</em>'; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <h3 class="resume-title">Education</h3>
                    <div class="resume-item">
                        <h4><?php echo $programData['course_name']; ?></h4>
                        <h5>Graduated in <?php echo $programData['batch']; ?></h5>
                    </div>
                </div>
                <div class="col-lg-6 ms-3 ms-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="resume-title">Professional Experience</h3>

                    <?php
                        $workHistoryQuery = "SELECT * FROM workHistory WHERE user_id = ? ORDER BY workEnd DESC";
                        $workHistoryStmt = mysqli_prepare($conn, $workHistoryQuery);
                        
                        if ($workHistoryStmt && isset($alumniData['user_id'])) {
                            mysqli_stmt_bind_param($workHistoryStmt, "i", $alumniData['user_id']);
                            mysqli_stmt_execute($workHistoryStmt);
                        
                            $workHistoryResult = mysqli_stmt_get_result($workHistoryStmt);
                        
                            if (mysqli_num_rows($workHistoryResult) > 0) {
                                while ($row = mysqli_fetch_assoc($workHistoryResult)) {
                                    echo '<div class="resume-item">';
                                    echo '<h4>' . $row['position'] . '</h4>';
                                    $formattedWorkStart = date('Y M', strtotime($row['workStart']));
                                    $formattedWorkEnd = ($row['workEnd'] == 'Present') ? 'Present' : date('Y M', strtotime($row['workEnd']));
                                    echo '<h5>' . $formattedWorkStart . ' - ' . $formattedWorkEnd . '</h5>';
                                    echo '<p><em>' . $row['company'] . '</em></p>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No professional experience information available.</p>';
                            }

                            mysqli_stmt_close($workHistoryStmt);
                        } else {
                            echo '<div class="resume-item">';
                            echo '<p>No professional experience information available.</p>';
                            echo '</div>';
                        }             
                        
                        ?>
                </div>
            </div>

        </div>
    </section>



</body>
<script src="../bootstrap/bs.js"></script>

</html>