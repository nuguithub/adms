<?php 
    require '../connectDB.php';

    $courseQuery = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = mysqli_prepare($conn, $courseQuery);
    mysqli_stmt_bind_param($stmt, "i", $course_id); 
    mysqli_stmt_execute($stmt);
    $courseResult = mysqli_stmt_get_result($stmt);
    $courseData = mysqli_fetch_assoc($courseResult);
    mysqli_stmt_close($stmt);
?>

<!-- Modal -->
<div class="modal fade" id="editCourseModal_<?php echo $course_id; ?>" tabindex="-1"
    aria-labelledby="editCourseModalLabel_<?php echo $course_id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel_<?php echo $course_id; ?>">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/update_course.php" method="post">
                <div class="modal-body text-start">

                    <input type="text" name="id" value="<?php echo $courseData['course_id']; ?>" hidden>

                    <div class="mb-3">
                        <label for="departments">Department</label>
                        <select class="form-select" aria-label="Department" name="department_id">
                            <?php
                            $selected = $courseData['department_id'];

                            // Fetch the selected department
                            $selectQuery = "SELECT * FROM departments WHERE dept_id = $selected";
                            $resultSelect = mysqli_query($conn, $selectQuery);
                            $sel = mysqli_fetch_assoc($resultSelect);

                            echo '<option selected value="' . $selected . '">' . $sel['dept_code'] . ' - ' . $sel['dept_name'] . '</option>';

                            // Fetch all other departments excluding the selected one
                            $query = "SELECT * FROM departments WHERE dept_id <> $selected";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['dept_id'] . '">' . $row['dept_code'] . ' - ' . $row['dept_name'] . '</option>';
                            }
                            ?>

                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="course_code">Course Code</label>
                        <input type="text" class="form-control" placeholder="Course Code" aria-label="Course Code"
                            name="course_code" value="<?php echo $courseData['course_code']; ?>">
                    </div>
                    <div class="">
                        <label for="course_name">Course Description</label>
                        <input type="text" class="form-control" placeholder="Course Name" aria-label="Course Name"
                            name="course_name" value="<?php echo $courseData['course_name']; ?>">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Course</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>