<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../connectDB.php'; 

$deptQuery = "SELECT dept_name FROM departments WHERE dept_code = ?";
$stmtx = $conn->prepare($deptQuery);
$stmtx->bind_param("s", $college);
$stmtx->execute();
$stmtx->bind_result($deptName);
$stmtx->fetch();
$stmtx->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addAlumni'])) {
    $student_number = $_POST["studentNumber"];
    $fname = ucwords(strtolower($_POST["fname"]));
    $mname = ucwords(strtolower($_POST["mname"]));
    $lname = ucwords(strtolower($_POST["lname"]));
    $gender = $_POST["gender"];
    $civil_status = $_POST["civil_status"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $department = $_POST["department"];
    $course = $_POST["course"];
    $batch = $_POST["batch"];

    // Check if any of the required fields are empty
    if (empty($student_number) || empty($fname) || empty($lname) || empty($gender) || empty($civil_status) || empty($birthday) || empty($department) || empty($course) || empty($batch)) {
        $message = "All fields are required.";
    } else {

        // Proceed with the database operations
        $checkQuery = "SELECT student_number FROM alumni WHERE student_number = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $student_number);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $_SESSION['updAlumniMess'] = ["A student with the same student number already exists.", "warning"];
        } else {
                
            $addAlumniQuery = "INSERT INTO alumni (student_number, fname, mname, lname, gender, civil_status, birthday, address_) 
                            VALUES ('$student_number', '$fname', '$mname', '$lname', '$gender', '$civil_status', '$birthday', '$address')";
            $alumniInsertResult = mysqli_query($conn, $addAlumniQuery);
                
            if ($alumniInsertResult) {
            $lastInsertedId = mysqli_insert_id($conn);
                
                $insertProgramQuery = "INSERT INTO alumni_program (alumni_id, coll_dept, coll_course, batch) 
                                    VALUES ('$lastInsertedId', '$college', '$course', '$batch')";
                $programInsertResult = mysqli_query($conn, $insertProgramQuery);
                
                if ($programInsertResult) {
                    $_SESSION['updAlumniMess'] = ["Alumni record added successfully.", "success"];
                } else {
                    $_SESSION['updAlumniMess'] = ["Failed to add program information.", "danger"];
                }
                
            } else {
                $_SESSION['updAlumniMess'] = ["Failed to add alumni record.", "danger"];
            }
        }
        
    }
}


?>

<div class="modal fade" id="addAlumniModal" tabindex="-1" aria-labelledby="addAlumniModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content text-start overflow-auto" style="max-height: 50vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlumniModalLabel"><strong>Add Alumni</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div id="error-message" class="alert alert-danger w-100 d-none" style="font-size: 14px;"></div>

                    <div class="mb-1">
                        <label for="studentNumber" class="form-label fw-semibold mb-0">Student Number</label>
                        <input type="text" class="form-control" name="studentNumber" maxlength="9"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>

                    <div class="mb-1">
                        <label for="fname" class="form-label fw-semibold mb-0">First Name</label>
                        <input type="text" class="form-control" name="fname" required>
                    </div>

                    <div class="mb-1">
                        <label for="mname" class="form-label fw-semibold mb-0">Middle Name</label>
                        <input type="text" class="form-control" name="mname" required>
                    </div>

                    <div class="mb-1">
                        <label for="lname" class="form-label fw-semibold mb-0">Last Name</label>
                        <input type="text" class="form-control" name="lname" required>
                    </div>

                    <div class="mb-1">
                        <label for="gender" class="form-label fw-semibold mb-0">Gender</label>
                        <div class="ms-3">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="Male"
                                    checked required>
                                <label class="form-check-label" for="maleRadio">
                                    Male
                                </label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="gender" id="femaleRadio"
                                    value="Female" required>
                                <label class="form-check-label" for="femaleRadio">
                                    Female
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="otherRadio" value="Other"
                                    required>
                                <label class="form-check-label" for="otherRadio">
                                    Other
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="mb-1">
                        <label for="civil_status" class="form-label fw-semibold mb-0">Civil Status</label>
                        <select class="form-select" name="civil_status" required>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="birthday" class="form-label fw-semibold mb-0">Birthday</label>
                        <input type="date" class="form-control" name="birthday" required>
                    </div>

                    <div class="mb-1">
                        <label for="address" class="form-label fw-semibold mb-0">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>

                    <div class="mb-1">
                        <label for="department" class="form-label fw-semibold mb-0">Department</label>
                        <select class="form-select" name="department">
                            <option value="<?php echo $college;?>" selected><?php echo $college .' - '. $deptName;?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="course" class="form-label fw-semibold mb-0">Course</label>
                        <select class="form-select" name="course" required>
                            <option selected value="">Select Course</option>
                            <?php 
                                $CoursesQuery = mysqli_query($conn, "SELECT courses.*, departments.* 
                                        FROM courses 
                                        INNER JOIN departments ON courses.department_id = departments.dept_id
                                        WHERE departments.dept_code = '$college'");
    
                                while ($row = mysqli_fetch_assoc($CoursesQuery)) {
                                    echo "<option value='{$row['course_code']}'>{$row['course_code']} - {$row['course_name']}</option>";
                                }
                            ?>
                        </select>
                    </div>


                    <div>
                        <label for="batch" class="form-label fw-semibold mb-0">Year Graduated</label>
                        <input type="text" class="form-control" name="batch" required>
                    </div>

                    <div class="text-end pt-3">
                        <input type="submit" name="addAlumni" class="btn btn-primary px-5" value="Add Alumni" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>