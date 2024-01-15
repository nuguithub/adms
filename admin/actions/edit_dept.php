<?php 
    require '../connectDB.php';

    $deptQuery = "SELECT * FROM departments WHERE dept_id = ?";
    $stmt = mysqli_prepare($conn, $deptQuery);
    mysqli_stmt_bind_param($stmt, "i", $dept_id); 
    mysqli_stmt_execute($stmt);
    $deptResult = mysqli_stmt_get_result($stmt);
    $deptData = mysqli_fetch_assoc($deptResult);
    mysqli_stmt_close($stmt);
?>

<!-- Modal -->
<div class="modal fade" id="editDeptModal_<?php echo $dept_id; ?>" tabindex="-1"
    aria-labelledby="editDeptModalLabel_<?php echo $dept_id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeptModalLabel_<?php echo $dept_id; ?>">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/update_dept.php" method="post">
                <div class="modal-body text-start">

                    <input type="text" name="id" value="<?php echo $deptData['dept_id']; ?>" hidden>

                    <div class="mb-3">
                        <label for="dept_code">Course Code</label>
                        <input type="text" class="form-control" placeholder="Department Code" name="dept_code"
                            value="<?php echo $deptData['dept_code']; ?>">
                    </div>
                    <div class="">
                        <label for="dept_name">Course Description</label>
                        <input type="text" class="form-control" placeholder="Department Name" name="dept_name"
                            value="<?php echo $deptData['dept_name']; ?>">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Department</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>