<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['agreed']) || $_SESSION['agreed'] !== true) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "<script>
        function expireSession() {
            alert('Registration time expired.');
            window.location.href = 'logout-act.php';
        }
        setTimeout(expireSession, 10 * 60 * 1000);
    </script>";

}

require_once 'connectDB.php'; 

$departmentOptions = '';
$departmentsQuery = mysqli_query($conn, "SELECT * FROM departments");
while ($row = mysqli_fetch_assoc($departmentsQuery)) {
    $departmentOptions .= "<option value='{$row['dept_code']}'>{$row['dept_code']} - {$row['dept_name']}</option>";
}

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNumber = $_POST["student_number"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $selectedDepartment = $_POST["department"];
    $selectedCourse = $_POST["course"];

    // Check if an account with the same student number exists
    $accountCheckerQuery = mysqli_prepare($conn, "SELECT COUNT(*) FROM alumni WHERE student_number = ? AND user_id IS NOT NULL");
    mysqli_stmt_bind_param($accountCheckerQuery, "i", $studentNumber);
    mysqli_stmt_execute($accountCheckerQuery);

    $accountCheckResult = mysqli_stmt_get_result($accountCheckerQuery);
    $rowCount = mysqli_fetch_row($accountCheckResult)[0];

    if ($rowCount > 0) {
        $errorMessage = "An account with this student number already exists.";
    } else {
        // Check if an account with the same details exists
        $validationQuery = mysqli_prepare($conn, "SELECT COUNT(*) 
                                        FROM alumni a
                                        JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
                                        WHERE a.student_number = ? 
                                        AND a.fname = ? 
                                        AND a.lname = ? 
                                        AND ap.coll_dept = ? 
                                        AND ap.coll_course = ?
                                        AND archive IS NULL");

        mysqli_stmt_bind_param($validationQuery, "sssss", $studentNumber, $fname, $lname, $selectedDepartment, $selectedCourse);
        mysqli_stmt_execute($validationQuery);

        $validationResult = mysqli_stmt_get_result($validationQuery);
        $rowCount = mysqli_fetch_row($validationResult)[0];

        if ($rowCount === 1) {
            $_SESSION['student_number'] = $studentNumber;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['department'] = $selectedDepartment;
            $_SESSION['course'] = $selectedCourse;
            header("Location: register_step2.php");
            exit;
        } else {
            $errorMessage = "No account matches these details. Please check your information.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard.css">
    <style>
    input,
    select {
        border-radius: 0 !important;
    }

    input:focus,
    select:focus {
        box-shadow: 0 0 #3330 !important;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php';?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="my-5 d-flex justify-content-center align-items-center">
                    <div class="card">
                        <div class="card-body m-5">
                            <div class="card-title">
                                <h3>Registration</h3>
                            </div>
                            <hr>
                            <?php if (!empty($errorMessage)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" style="font-size: 14px;"
                                role="alert">
                                <?php echo $errorMessage; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <form action="register_step1.php" method="post">

                                <div class="mb-2">
                                    <label for="student_number" class="form-label fw-semibold mb-0">Student
                                        Number</label>
                                    <input type="text" class="form-control" name="student_number" required>
                                </div>

                                <div class="mb-2">
                                    <label for="fname" class="form-label fw-semibold mb-0">First Name</label>
                                    <input type="text" class="form-control" name="fname" required>
                                </div>

                                <div class="mb-2">
                                    <label for="lname" class="form-label fw-semibold mb-0">Last Name</label>
                                    <input type="text" class="form-control" name="lname" required>
                                </div>

                                <div class="mb-2">
                                    <label for="department" class="form-label fw-semibold mb-0">Department</label>
                                    <select class="form-select" name="department" required>
                                        <option selected>Select Department</option>
                                        <?php echo $departmentOptions; ?>
                                    </select>
                                </div>
                                <div class="">
                                    <label for="course" class="form-label fw-semibold mb-0">Course</label>
                                    <select class="form-select" name="course" required>
                                        <option selected>Select Course</option>
                                    </select>
                                </div>

                                <div class="text-center text-lg-end pt-3">
                                    <button type="submit" class="btn btn-primary px-5">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/bs.js"></script>
    <script>
    // for select course
    const departmentSelect = document.getElementsByName("department")[0];
    const courseSelect = document.getElementsByName("course")[0];

    departmentSelect.addEventListener("change", () => {
        const selectedDepartment = departmentSelect.value;

        console.log("Selected Department:", selectedDepartment); //for debug

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                console.log("Response from get_courses.php:", xhr.responseText); //for debug

                if (xhr.status === 200) {
                    const courses = JSON.parse(xhr.responseText);
                    courseSelect.innerHTML = "";
                    for (const course of courses) {
                        const option = document.createElement("option");
                        option.value = course.course_code;
                        option.textContent = course.course_code + ' - ' + course.course_name;
                        courseSelect.appendChild(option);
                    }
                }
            }
        };
        xhr.open("GET", `get_courses.php?dept_code=${selectedDepartment}`, true);
        xhr.send();
    });


    // for activeLink
    const registerLink = document.querySelector('.navbar-text .nav-item:last-child .nav-link');
    registerLink.classList.add('text-white', 'fw-semibold');
    window.removeEventListener('scroll', handleScroll);
    </script>
</body>

</html>