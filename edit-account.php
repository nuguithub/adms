<?php
    include 'connectDB.php';

    $sql = "SELECT a.*
        FROM alumni a
        WHERE a.alumni_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $alumId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $fBday = date('Y-m-d', strtotime($bday));
?>

<!-- Modal -->
<div class="modal fade" id="editAccountModal_<?php echo $alumId; ?>" tabindex="-1"
    aria-labelledby="editAccountModalLabel_<?php echo $alumId; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAccountModalLabel_<?php echo $alumId; ?>">Account Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <form action="update-info.php" method="post">

                    <input type="hidden" name="id" value="<?php echo $alumId; ?>" />


                    <div class="mb-2">
                        <label for="fname" class="mb-0 fs-6 fw-semibold">First Name</label>
                        <input type="text" class="form-control" name="fname" value="<?php echo $fname;?>">
                    </div>
                    <div class="mb-2">
                        <label for="mname" class="form-label mb-0 fs-6 fw-semibold">Middle Name</label>
                        <input type="text" class="form-control" name="mname" value="<?php echo $mname;?>">
                    </div>
                    <div class="mb-2">
                        <label for="lname" class="form-label mb-0 fs-6 fw-semibold">Last Name</label>
                        <input type="text" class="form-control" name="lname" value="<?php echo $lname;?>">
                    </div>
                    <div class="mb-2">
                        <label for="gender" class="form-label mb-0 fs-6 fw-semibold">Sex</label>
                        <select class="form-control" name="gender">
                            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female
                            </option>
                            <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="birthday" class="form-label mb-0 fs-6 fw-semibold">Birthday</label>
                        <input type="date" class="form-control" name="birthday" value="<?php echo $fBday; ?>">
                    </div>
                    <div class="mb-2">
                        <label for="civil_status" class="form-label fs-6 fw-semibold">Civil
                            Status</label>
                        <select class="form-select" name="civilStat">
                            <?php
                            $enumValues = ["Single", "Married", "Divorced", "Widowed", "Other"];
                            foreach ($enumValues as $enumValue) {
                                $selected = ($row['civil_status'] === $enumValue) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($enumValue) . '" ' . $selected . '>' . htmlspecialchars($enumValue) . '</option>';
                            }
                            ?>
                        </select>

                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="editInfo" class="btn btn-sm btn-primary">Update Info</button>
            </div>
            </form>
        </div>
    </div>
</div>