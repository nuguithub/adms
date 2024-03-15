<?php
// Fetch achievement data
$sqlAch = "SELECT * FROM achievements WHERE id = ?";
$stmtAch = mysqli_prepare($conn, $sqlAch);
mysqli_stmt_bind_param($stmtAch, "i", $achID);
mysqli_stmt_execute($stmtAch);
$result = mysqli_stmt_get_result($stmtAch);
$achRow = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmtAch);
?>

<div class="modal fade" id="updAchModal_<?php echo $achID ?>" tabindex="-1" role="dialog"
    aria-labelledby="updAchModalLabel_<?php echo $achID ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="save-ach.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="updAchModalLabel_<?php echo $achID ?>">Edit Achievement/Award</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">

                    <input type="hidden" name="id" value="<?php echo $achID; ?>" />

                    <div class="mb-2">
                        <label for="achievement"><strong>Achievement / Award</strong> </label>
                        <input type="text" name="achievement" class="form-control"
                            value="<?php echo $achRow['achievement']; ?>">
                    </div>

                    <div class="mb-2">
                        <label for="org"><strong>Awarding Body</strong> </label>
                        <input type="text" name="org" class="form-control" value="<?php echo $achRow['org']; ?>">
                    </div>

                    <div class="mb-2">
                        <label for="date"><strong>Date Acquired</strong> </label>
                        <input type="date" name="date" class="form-control" value="<?php echo $achRow['date']; ?>">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="saveAch" class="btn btn-sm btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>