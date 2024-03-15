<?php
session_start();
include 'connectDB.php';

// Redirect if the user is not logged in as an alumni
if (!isset($_SESSION['username']) || $_SESSION['role_'] !== 'alumni') {
    header('Location: logout-act.php');
    exit();
}

$username = $_SESSION['username'];

// Function to fetch a single value from a prepared statement
function fetchSingleValue($stmt, $paramType, $paramValue) {
    $stmt->bind_param($paramType, $paramValue);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Fetch user ID
$queryUser = "SELECT user_id FROM users WHERE username = ?";
$stmtUser = $conn->prepare($queryUser);
$user = fetchSingleValue($stmtUser, "s", $username);
$userId = $user ? $user['user_id'] : 0;

// Fetch alumni details with join on departments, courses, and careers
$queryAlumni = "SELECT a.*, aa.achievement, aa.date
                FROM alumni a
                LEFT JOIN achievements aa ON a.alumni_id = aa.alumni_id
                WHERE a.user_id = ?";

$stmtAlumni = $conn->prepare($queryAlumni);
$alumni = fetchSingleValue($stmtAlumni, "i", $userId);

if ($alumni) {
    $alumId = $alumni['alumni_id'];
    $myCareerQuery = "SELECT position FROM workHistory WHERE user_id = ? AND workEnd = 'Present'";
    $stmtWork = $conn->prepare($myCareerQuery);
    $work = fetchSingleValue($stmtWork, "i", $userId);
    $myCareer = $work ? $work['position'] : "";
    
    // Extract alumni details
    $fname = $alumni['fname'];
    $mname = $alumni['mname'];
    $mInitial = $alumni['mname'] ? substr($alumni['mname'], 0, 1) . '.' : '';
    $lname = $alumni['lname'];
    $name = $lname . ', ' . $fname . ' ' . $mInitial;
    $gender = $alumni['gender'];
    $civil_status = $alumni['civil_status'];
        $birthday = $alumni['birthday'];
    $formattedBday = new DateTime($birthday);
    $bday = $formattedBday->format('F d, Y');
    $address = $alumni['address_'];
    $contact_no = $alumni['contact_no'];
    $email = $alumni['email'];
    // $dept = $alumni['dept_name']; // Use the joined department name
    // $course = $alumni['course_name']; // Use the joined course name
    // $batch = $alumni['batch'];
    $achievements = $alumni['achievement'];
}

// Close prepared statements and the database connection
$stmtAlumni->close();
$stmtUser->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link rel="stylesheet" href="assets/dashboard.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    #pp {
        border: .3rem solid #381;
    }

    .profilePic i {
        background-color: #492 !important;
        padding: .5rem;
        color: #ddd;
        margin-top: 95px;
        margin-left: 111px;
    }

    .profilePic i:hover {
        background-color: #4a2 !important;
    }

    #contacts p,
    span {
        font-size: .95em;
    }

    #personal hr {
        margin: 5px 0;
    }

    #hovThis {
        display: none;

    }

    #hovMe:hover+#hovThis,
    #hovThis:hover {
        display: block;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php';?>

    <div class="container">
        <div class="row pt-5">
            <h2 class="mb-3 ms-lg-4 fw-bolder">Profile</h2>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <?php
                                if (!empty($alumni['img'])) {
                                ?>
                            <div class="position-relative">
                                <img id="pp" src="img/alumni/<?php echo $alumni['img']; ?>" alt="Profile Pic"
                                    class="rounded-circle object-fit-cover" width="150" height="150">
                                <a class="profilePic position-absolute top-50 start-50 translate-middle p-2"
                                    href="#changeProfileModal_<?php echo $alumId; ?>" data-bs-toggle="modal"><i
                                        class="far fa-camera rounded-circle"></i></a>
                            </div>

                            <?php
                                } else {
                                ?>
                            <div class="position-relative">
                                <img id="pp" src="img/alumni/no-image.png" alt="Profile Pic"
                                    class="rounded-circle object-fit-cover" width="150" height="150">
                                <a class="profilePic position-absolute top-50 start-50 translate-middle p-2"
                                    href="#changeProfileModal_<?php echo $alumId; ?>" data-bs-toggle="modal"><i
                                        class="far fa-camera rounded-circle"></i></a>
                            </div>

                            <?php
                                }
                                include 'change-profile.php';
                                ?>

                            <div class=" mt-3">
                                <h4><?php echo $name;?></h4>
                                <p class="text-secondary mb-1"> <strong>Current Work: </strong>
                                    <?php
                                        echo ($myCareer === null || $myCareer === "") ? "No career info." : $myCareer;
                                    ?>
                                </p>
                            </div>

                            <?php
                            if (isset($_SESSION['profileStat'])) {
                                $mess1 = $_SESSION['profileStat'][0];
                                $alertType = $_SESSION['profileStat'][1];
                                unset($_SESSION['profileStat']); 
                            ?>

                            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show"
                                style="font-size: .8rem;" role="alert">
                                <?php echo $mess1; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <!-- EDUCATION -->
                <div class="card mt-3 px-4 p-3">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-bold">EDUCATION</p>
                        <a href="#editEducModal_<?php echo $alumId; ?>" data-bs-toggle="modal"
                            class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                            style="font-size: .8em;">Edit</a>

                        <?php 
                            include 'editEduc.php';
                            include 'add-achievement.php';?>
                    </div>

                    <?php
                            if (isset($_SESSION['educStat'])) {
                                $mess1 = $_SESSION['educStat'][0];
                                $alertType = $_SESSION['educStat'][1];
                                unset($_SESSION['educStat']); 
                            ?>

                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show"
                        style="font-size: .8rem;" role="alert">
                        <?php echo $mess1; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <?php
                            }
                            ?>

                    <?php
                    $sql = "SELECT ap.*, d.dept_name, c.course_name
                            FROM alumni_program ap
                            LEFT JOIN departments d ON ap.coll_dept = d.dept_code
                            LEFT JOIN courses c ON ap.coll_course = c.course_code
                            WHERE alumni_id = $alumId";

                    $resProg = $conn->query($sql);
                    
                    if ($resProg->num_rows > 0) {
                        while ($rowx = $resProg->fetch_assoc()) {
                            $dept = $rowx['dept_name'];
                            $course = $rowx['course_name'];
                            $batch = $rowx['batch'];
                            // Display information for each program
                    ?>
                    <hr class="mx-3 my-1">
                    <p class="mb-0 fw-bold">Programme: <span class="text-secondary"
                            style="font-size: 16px;"><?php echo $course;?></span></p>
                    <p class="mb-0 fw-bold">Year Graduated: <span class="text-secondary"
                            style="font-size: 16px;"><?php echo $batch;?></span></p>
                    <?php
                    }
                    } else {
                        echo '<p class="text-secondary">No programs found for the alumni.</p>';
                    }

                    if (!empty($achievements)) { ?>
                    <hr class="mx-3 my-1">
                    <p class="mb-0 fw-bold">Achievements</p>

                    <div id="hovMe">
                        <ul class="">
                            <?php
                                $queAch = "SELECT * FROM achievements WHERE alumni_id = '$alumId'";
                                $resultAch = mysqli_query($conn, $queAch);
                                while ($achieveRow = mysqli_fetch_assoc($resultAch)) {
                                    $achID = $achieveRow['id'];
                                    $achieveValue = empty($achieveRow['achievement']) ? 'No data available' : $achieveRow['achievement'];
                                    if (strlen($achieveValue) > 8) {
                                        $achieveValue = substr($achieveValue, 0, 5) . '...';
                                    }
                                    $org = empty($achieveRow['org']) ? 'No data available' : $achieveRow['org'];
                                    if (strlen($org) > 8) {
                                        $org = substr($org, 0, 5) . '...';
                                    }
                                    $dateAcq = date('M d, Y', strtotime($achieveRow['date']));
                                    $dateValue = empty($dateAcq) ? '' : ' (' . $dateAcq . ')';
                                    ?>

                            <li id="hovMe" class="text-secondary" style="font-size: 16px;">
                                <?php echo $achieveValue .', '. $org. $dateValue; ?>
                            </li>
                            <span class="ms-auto" id="hovThis">
                                <a href="#updAchModal_<?php echo $achID ?>"
                                    class="pe-2 link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                    data-bs-toggle="modal" data-bs-backdrop="false" style="font-size: .8em;">Edit</a>
                                <a class="pe-lg-5 link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                    href="delAch.php?id=<?php echo $achID ?>" style="font-size: .8em;"
                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                            </span>
                            <?php include 'updAch.php'; ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>

                </div>

                <!-- CONTACTS -->
                <div class="card mt-3 px-4 p-3" id="contacts">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-bolder">CONTACT</p>
                        <a href="#editContactModal_<?php echo $alumId; ?>"
                            class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                            data-bs-toggle="modal" style="font-size: .8em;">Edit</a>
                        <?php include 'editContact.php';?>
                    </div>
                    <?php
                            if (isset($_SESSION['contactStat'])) {
                                $mess1 = $_SESSION['contactStat'][0];
                                $alertType = $_SESSION['contactStat'][1];
                                unset($_SESSION['contactStat']); 
                            ?>

                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show"
                        style="font-size: .8rem;" role="alert">
                        <?php echo $mess1; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <?php
                            }
                            ?>
                    <div class="ms-2">
                        <p class="mb-0 fw-bold">Address:
                            <span class="text-secondary fw-normal">
                                <?php
                            if ($address === null || $address === "") {
                                echo "No address available.";
                            } else {
                                echo $address;
                            }
                            ?>
                            </span>
                        </p>
                        <p class="mb-0 fw-bold">Email:
                            <span class="fw-normal text-secondary">
                                <?php
                            if ($email === null || $email === "") {
                                echo "No email available.";
                            } else {
                                echo $email;
                            }
                            ?>
                            </span>
                        </p>
                        <p class="mb-0 fw-bold">Contact Number:
                            <span class="fw-normal text-secondary">
                                <?php
                            if ($contact_no === null || $contact_no === "") {
                                echo "No mobile number available.";
                            } else {
                                echo $contact_no;
                            }
                            ?>
                            </span>
                        </p>
                    </div>
                </div>

            </div>

            <div class="col-md-8">
                <div class="card mb-3">

                    <!-- PERSONAL -->
                    <div class="card-body" id="personal">
                        <p class="mb-3 fw-bolder">PERSONAL</p>

                        <?php
                            if (isset($_SESSION['profStat'])) {
                                $mess1 = $_SESSION['profStat'][0];
                                $alertType = $_SESSION['profStat'][1];
                                unset($_SESSION['profStat']); 
                            ?>

                        <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show"
                            style="font-size: .8rem;" role="alert">
                            <?php echo $mess1; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php
                            }
                            ?>

                        <div class="ms-3">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"><strong>First Name</strong> </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $fname;?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"><strong>Middle Name</strong> </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    echo ($mname === null || $mname === "") ? "" : $mname;
                                ?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"><strong>Last Name</strong> </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $lname;?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"><strong>Sex</strong> </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $gender;?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"><strong>Birthday</strong> </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $bday;?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"><strong>Civil Status</strong> </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    if ($civil_status === null || $civil_status === "") {
                                        echo "No civil status info.";
                                    } else {
                                        echo $civil_status;
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 text-end">
                            <a href="#editAccountModal_<?php echo $alumId; ?>" class="btn btn-sm btn-primary px-5"
                                data-bs-toggle="modal">Edit Personal Info</a>

                            <?php include 'edit-account.php';?>
                        </div>
                    </div>
                </div>


                <!-- WORK EXPERIENCE -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title fw-bolder">WORK EXPERIENCE</p>
                            <a href="#addWorkModal_<?php echo $userId; ?>"
                                class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                data-bs-toggle="modal" style="font-size: .8em;">Add</a>
                            <?php include 'add-work.php';?>
                        </div>

                        <?php
                        if (isset($_SESSION['workStatMess'])) {
                            $mess1 = $_SESSION['workStatMess'][0];
                            $alertType = $_SESSION['workStatMess'][1];
                            unset($_SESSION['workStatMess']); 
                        ?>

                        <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show"
                            style="font-size: .8rem;" role="alert">
                            <?php echo $mess1; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php
                        }
                        ?>

                        <div class="row">
                            <?php
                        $queryWorkHistory = "SELECT * FROM workHistory WHERE user_id = ? ORDER BY workEnd DESC";
                        $stmtWorkHistory = $conn->prepare($queryWorkHistory);
                        $stmtWorkHistory->bind_param("i", $userId);
                        $stmtWorkHistory->execute();
                        $resultWorkHistory = $stmtWorkHistory->get_result();
                        
                        if ($resultWorkHistory->num_rows > 0) {
                            while ($row = $resultWorkHistory->fetch_assoc()) {
                                $start = new DateTime($row['workStart']);
                                $workStart = $start->format("Y M");
                                if ($row['workEnd'] == 'Present') {
                                    $row['workEnd'] = DATE("Y M");
                                    $end = new DateTime($row['workEnd']);
                                    $workEnd = "PRESENT";
                                } else {
                                    $end = new DateTime($row['workEnd']);
                                    $workEnd = $end->format("Y M");
                                }

                                $workDate = $workStart . ' - ' . $workEnd;
                                $interval = $start->diff($end);
                                $years = $interval->y;
                                $months = $interval->m;

                                if ($years > 0) {
                                    $workSpan = "$years year" . ($years > 1 ? 's' : '');
                                    if ($months > 0) {
                                        $workSpan .= ", $months month" . ($months > 1 ? 's' : ''); // Concatenate months
                                    }
                                } elseif ($months > 0) {
                                    $workSpan = "$months month" . ($months > 1 ? 's' : '');
                                } else {
                                    $workSpan = "Less than a month"; // Handle the case when the work span is less than a month
                                }

                                $company = $row['company'] ?? '';
                                $compAdd = $row['company_address'] ?? '';
                                $position = $row['position'] ?? '';
                                $empStat = $row['empStat'] ?? '';
                                $workId = $row['work_id'] ?? '';
                                
                        
                                include 'updWork.php'; ?>

                            <div class="row">
                                <div class="col-5 ps-lg-5 d-flex flex-column">
                                    <p class="mb-0 fw-semibold"><?php echo $company .', '. $compAdd; ?></p>
                                    <p class="text-secondary" style="font-size: .85em;">
                                        <?php echo $position; ?> - <?php echo $empStat; ?></p>
                                </div>
                                <div class="col-7 text-end pe-lg-5">
                                    <div id="hovMe">
                                        <p class="mb-0 pe-lg-5 fw-semibold" style="font-size: .8em;">
                                            <?php echo $workDate; ?>
                                        </p>
                                        <p class="text-secondary pe-lg-5 mb-0" style="font-size: .8em;">
                                            <?php echo $workSpan; ?>
                                        </p>
                                    </div>
                                    <span id="hovThis" class="mb-0">
                                        <a href="#updWorkModal_<?php echo $workId ?>"
                                            class="pe-2 link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                            data-bs-toggle="modal" data-bs-backdrop="false"
                                            style="font-size: .8em;">Edit</a>

                                        <a class="pe-lg-5 link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                            href="delWork.php?id=<?php echo $workId ?>" style="font-size: .8em;"
                                            onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                                    </span>
                                </div>
                            </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="col-12 text-center">
                                <p> No work history available.</p>
                            </div>
                            <?php
                        }
                        
                        $stmtWorkHistory->close();
                        ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


</body>
<script src="bootstrap/bs.js"></script>
<script src="bootstrap/popper.min.js"></script>
<script>
const positionSelect = document.querySelector('[name="position"]');
const otherCareerContainer = document.getElementById('otherCareerContainer');
const otherCareerInput = document.getElementById('otherCareer');

positionSelect.addEventListener('change', function() {
    if (positionSelect.value === 'other') {
        otherCareerContainer.style.display = 'block';
        otherCareerInput.required = true;
    } else {
        otherCareerContainer.style.display = 'none';
        otherCareerInput.required = false;
    }
});
</script>

</html>