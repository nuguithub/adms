<?php
    require_once '../connectDB.php';
    
    $deptOptions = '';

    $id=$value['alumni_id'];

    $sql = "SELECT DISTINCT a.alumni_id, a.*, ap.* 
        FROM alumni a
        LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
        WHERE a.alumni_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id); 
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
?>

<!-- Modal -->
<div class="modal fade" id="editAlumniModal_<?php echo $id; ?>" tabindex="-1"
    aria-labelledby="editAlumniModalLabel_<?php echo $id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <h5 class="modal-title" id="editAlumniModalLabel_<?php echo $id; ?>">Edit Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <form action="actions/update_alumni.php" method="post" enctype="multipart/form-data">

                    <input type="text" name="id" value="<?php echo $data['alumni_id']; ?>" hidden>

                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" placeholder="2020XXXXX" name="student_number"
                            value="<?php echo $data['student_number']; ?>">
                        <label>Student Number</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" placeholder="Juan" name="fname"
                            value="<?php echo $data['fname']; ?>">
                        <label>First Name</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" placeholder="Dela Cruz" name="lname"
                            value="<?php echo $data['lname']; ?>">
                        <label>Last Name</label>
                    </div>
                    <div class="form-floating mb-1">
                        <select class="form-control" name="gender">
                            <option value="Male" <?php echo ($data['gender'] == 'Male') ? 'selected' : ''; ?>>Male
                            </option>
                            <option value="Female" <?php echo ($data['gender'] == 'Female') ? 'selected' : ''; ?>>Female
                            </option>
                            <option value="Other" <?php echo ($data['gender'] == 'Other') ? 'selected' : ''; ?>>Other
                            </option>
                        </select>
                        <label>Gender</label>
                    </div>

                    <div class="form-floating mb-1">
                        <select class="form-select" name="coll_dept" id="coll_dept" disabled>
                            <option value="<?php echo $data['coll_dept'];?>" selected><?php echo $data['coll_dept'];?>
                            </option>
                            <?php 
                                $collDept = $data['coll_dept'];
                                $deptsQuery = mysqli_query($conn, "SELECT * FROM departments WHERE dept_code != '$collDept'");
                                while ($row = mysqli_fetch_assoc($deptsQuery)) {
                                    echo "<option value='{$row['dept_code']}'>{$row['dept_code']}</option>";
                                }
                            ?>
                        </select>
                        <label>Department</label>
                    </div>

                    <div class="form-floating mb-1">
                        <select class="form-select" name="coll_course" id="coll_course">
                            <option value="<?php echo $data['coll_course'];?>" selected>
                                <?php echo $data['coll_course'];?>
                            </option>
                            <?php 
                                $collCourse = $data['coll_course'];
                                $CoursesQuery = mysqli_query($conn, "SELECT courses.*, departments.* 
                                        FROM courses 
                                        INNER JOIN departments ON courses.department_id = departments.dept_id
                                        WHERE course_code != '$collCourse' AND departments.dept_code = '$collDept'");
    
                                while ($row = mysqli_fetch_assoc($CoursesQuery)) {
                                    echo "<option value='{$row['course_code']}'>{$row['course_code']}</option>";
                                }
                            ?>
                        </select>
                        <label>Course</label>
                    </div>

                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" placeholder="Batch" name="batch"
                            value="<?php echo $data['batch']; ?>">
                        <label>Batch</label>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>