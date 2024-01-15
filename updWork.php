<?php
    include 'connectDB.php';

    $sqlWork = "SELECT a.alumni_id, wh.*, ap.coll_dept, ap.coll_course
    FROM workHistory wh
    LEFT JOIN alumni a ON wh.user_id = a.user_id
    LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
    WHERE wh.work_id = ?";
    $stmtWork = mysqli_prepare($conn, $sqlWork);
    mysqli_stmt_bind_param($stmtWork, "i", $workId);
    mysqli_stmt_execute($stmtWork);
    $result = mysqli_stmt_get_result($stmtWork);
    $workRow = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmtWork);

    $formBday = date('Y-m-d', strtotime($bday));
?>

<div class="modal fade" id="updWorkModal_<?php echo $workId ?>" tabindex="-1" role="dialog"
    aria-labelledby="updWorkModalLabel_<?php echo $workId ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="save-work.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="updWorkModalLabel_<?php echo $workId ?>">New Work</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">

                    <input type="hidden" name="id" value="<?php echo $workId; ?>" />

                    <div class="mb-2">
                        <label for="company"><strong>Company</strong> </label>
                        <input type="text" name="company" class="form-control" value="<?php echo $workRow['company'];?>"
                            disabled>
                    </div>

                    <div class="mb-2">
                        <label for="position"><strong>Position</strong></label>
                        <select class="form-select" aria-label="position" name="position" disabled>
                            <?php
                                $selectedCareer = htmlspecialchars($workRow["position"]);

                                echo '<option value="' . $selectedCareer . '" selected>' . $selectedCareer . '</option>';
                                ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="empStat"><strong>Employment Status</strong></label>
                        <select class="form-select" aria-label="empStat" name="empStat" required>
                            <?php
    $selectedEmpStat = htmlspecialchars($workRow['empStat']);

    $customLabels = array(
        "COS" => "Contact of Service",
        "JO" => "Job Order",
        "WO" => "Work Order"
    );

    // Display the selected option as the first option
    echo '<option value="' . $selectedEmpStat . '" selected>' . $selectedEmpStat . '</option>';

    // Display the regular options
    $empStatOptions = array("Permanent", "Temporary");
    foreach ($empStatOptions as $option) {
        // Skip the selected option, as it has already been displayed
        if ($option !== $selectedEmpStat) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
    }

    // Display the custom labeled options
    foreach ($customLabels as $value => $label) {
        // Skip the selected option, as it has already been displayed
        if ($value !== $selectedEmpStat) {
            $selected = ($value === $selectedEmpStat) ? 'selected' : '';
            echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }
    }
    ?>
                        </select>

                    </div>

                    <div class="mb-2">
                        <?php 
                            $start = new DateTime($workRow['workStart']);
                            $workStart = $start->format("Y-m");
                            
                            if ($workRow['workEnd'] == 'Present') {
                                $workRow['workEnd'] = date("Y-m");
                                $end = new DateTime($workRow['workEnd']);
                            } else {
                                $end = new DateTime($workRow['workEnd']);
                                $workEnd = $end->format("Y-m");
                            }
                        ?>

                        <label for="workStart"><strong>Work Start</strong></label>
                        <input type="month" class="form-control" name="workStart"
                            value="<?php echo $workRow['workStart'];?>" min="yyyy-01" max="yyyy-12" required />

                    </div>

                    <div class="mb-2">
                        <label for="workEnd"><strong>Work End</strong> </label>
                        <input type="month" class="form-control" name="workEnd"
                            value="<?php echo $workRow['workEnd'];?>" min="yyyy-01" max="yyyy-12"
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
                    <button type="submit" name="saveWorkx" class="btn btn-sm btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>