<?php
    include 'connectDB.php';

    $sql = "SELECT a.*, wh.*, ap.coll_dept, ap.coll_course
            FROM alumni a
            LEFT JOIN workHistory wh ON a.user_id = wh.user_id
            LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
            WHERE a.alumni_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $alumId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
?>

<!-- Modal -->
<div class="modal fade" id="addWorkModal_<?php echo $userId; ?>" tabindex="-1"
    aria-labelledby="addWorkModalLabel_<?php echo $userId; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update-work.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWorkModalLabel_<?php echo $userId; ?>">New Work</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">

                    <input type="hidden" name="id" value="<?php echo $userId; ?>" />

                    <div class="mb-2">
                        <label for="company"><strong>Company</strong> </label>
                        <input type="text" name="company" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="work_location"><strong>Work Location</strong></label>
                        <select class="form-select" aria-label="work_location" name="work_location" required>
                            <option value="Local">Local</option>
                            <option value="Foreign">Foreign</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="company_address"><strong>Company Address</strong> </label>
                        <input type="text" name="company_address" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="position"><strong>Position</strong></label>
                        <select class="form-select" aria-label="position" name="position" required>
                            <?php
                                $selectedCareer = '';
                                $otherOptionSelected = false;

                                echo '<option value="">Select Career</option>';
                                echo '<option value="Unemployed">Unemployed</option>';  

                                $querySelect = "SELECT * FROM careers WHERE related = 'YES' AND department = '" . $row['coll_dept'] . "' AND course = '" . $row['coll_course'] . "'";
                                $result = mysqli_query($conn, $querySelect);

                                while ($rowCar = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $rowCar['career_name'] . '" ' . ($selectedCareer == $rowCar['career_name'] ? 'selected' : '') . '>' . $rowCar['career_name'] . '</option>';
                                }

                                if ($selectedCareer === 'other') {
                                    $otherOptionSelected = true;
                                }

                                $otherSelected = ($otherOptionSelected && $selectedCareer === 'other') ? 'selected' : '';
                                ?>
                            <option value="other" <?php echo $otherSelected; ?>>Other</option>
                        </select>
                    </div>
                    <div id="otherCareerContainer" class="ms-5 mb-2"
                        <?php echo ($otherSelected === 'selected') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                        <label for="otherCareer">Other Career:</label>
                        <input type="text" class="form-control" id="otherCareer" name="otherCareer" />
                    </div>

                    <div class="mb-2">
                        <label for="empStat"><strong>Employment Status</strong></label>
                        <select class="form-select" aria-label="empStat" name="empStat" required>
                            <option value="Permanent">Permanent</option>
                            <option value="Temporary">Temporary</option>
                            <option value="COS">Contact of Service</option>
                            <option value="JO">Job Order</option>
                            <option value="WO">Work Order</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <?php 
                            $start = new DateTime($row['workStart']);
                            $workStart = $start->format("Y-m");
                            
                            if ($row['workEnd'] == 'Present') {
                                $row['workEnd'] = date("Y-m");
                                $end = new DateTime($row['workEnd']);
                            } else {
                                $end = new DateTime($row['workEnd']);
                                $workEnd = $end->format("Y-m");
                            }
                        ?>

                        <label for="workStart"><strong>Work Start</strong></label>
                        <input type="month" class="form-control" name="workStart" value="" min="yyyy-01" max="yyyy-12"
                            required />

                    </div>

                    <div class="mb-2">
                        <label for="workEnd"><strong>Work End</strong> </label>
                        <input type="month" class="form-control" name="workEnd" value="" min="yyyy-01" max="yyyy-12"
                            aria-describedby="workHelp" />
                        <div id="workHelp" class="form-text text-end" style="font-size: .75rem">Leave "Work
                            End" blank
                            if
                            you're
                            currently working.</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="editWork" class="btn btn-sm btn-primary">Update Info</button>
                </div>
            </form>
        </div>
    </div>

</div>