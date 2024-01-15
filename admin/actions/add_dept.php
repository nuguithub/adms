<div class="modal fade" id="addDeptModal" tabindex="-1" aria-labelledby="addDeptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeptModalLabel">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="actions/add-dept_act.php">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Department Code"
                            aria-label="Department Code" name="dept_code" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Department Description"
                            aria-label="Department Description" name="dept_name" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="dept" class="btn btn-success">Add Department</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>