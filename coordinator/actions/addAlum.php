<div class="modal fade" id="addAlumniModal" tabindex="-1" aria-labelledby="addAlumniModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content text-start overflow-auto" style="max-height: 50vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlumniModalLabel"><strong>Add Alumni</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="actions/addAlumni.php">
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
                        <select class="form-select" name="department" disabled>
                            <?php
                            $deptQuery = "SELECT dept_name FROM departments WHERE dept_code = ?";
                            $stmtx = $conn->prepare($deptQuery);
                            $stmtx->bind_param("s", $college);
                            $stmtx->execute();
                            $stmtx->bind_result($deptName);
                            $stmtx->fetch();
                            $stmtx->close();
                            ?>
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