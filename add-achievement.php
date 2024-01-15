<!-- Modal -->

<div class="modal fade" id="addAchieveModal_<?php echo $alumId; ?>" aria-hidden="true"
    aria-labelledby="addAchieveModalToggleLabel_<?php echo $alumId; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAchieveModalToggleLabel_<?php echo $alumId; ?>">Add Achievement</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="addAchievement.php" method="post">
                <div class="modal-body text-start">

                    <input type="hidden" name="id" value="<?php echo $alumId; ?>" />

                    <div class="mb-2">
                        <label for="achievement"><strong>Achievement</strong> </label>
                        <input type="text" name="achievement" class="form-control" required>
                    </div>

                    <div class="mb-2">

                        <label for="date"><strong>Date Acquired</strong></label>
                        <input type="date" class="form-control" name="date" required />

                    </div>

                </div>
                <div class="modal-footer">
                    <button data-bs-target="#editEducModal_<?php echo $alumId; ?>" data-bs-toggle="modal"
                        class="btn btn-sm btn-secondary" style="font-size: .8em;">Back</button>
                    <button type="submit" name="addAchievement" class="btn btn-sm btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateDate() {
    var selectedDate = new Date(document.getElementById('date').value);
    var currentDate = new Date();

    if (selectedDate > currentDate) {
        document.getElementById('dateError').innerText = 'Date cannot be in the future';
        return false;
    } else {
        document.getElementById('dateError').innerText = '';
        return true;
    }
}
</script>