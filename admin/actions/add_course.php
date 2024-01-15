<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="actions/add-crs_act.php">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <select class="form-select" name="department_id" required>
                            <option selected>Department</option>
                            <?php
                            include '../connectDB.php';
                            $queryDept = "SELECT * FROM departments";

                            $optionResult = $conn->query($queryDept);

                            if ($optionResult->num_rows > 0) {
                                while ($row = $optionResult->fetch_assoc()) {
                                    $dept_id = $row['dept_id'];
                                    $dept_code = $row['dept_code'];
                                    $dept_name = $row['dept_name'];
                                    echo '<option value="' . $dept_id . '">' . $dept_code . " - " . $dept_name .'</option>';
                                }
                            } else {
                                echo '<option value="Not Available">Not Available</option>';
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Course Code" aria-label="Course Code"
                            name="course_code" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Course Description"
                            aria-label="Course Description" name="course_name" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="crs" class="btn btn-success">Add Course</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>