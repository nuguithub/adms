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
?>

<!-- Modal -->
<div class="modal fade" id="editContactModal_<?php echo $alumId; ?>" tabindex="-1"
    aria-labelledby="editContactModalLabel_<?php echo $alumId; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContactModalLabel_<?php echo $alumId; ?>">Edit Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <form action="update-contact.php" method="post">

                    <input type="hidden" name="id" value="<?php echo $alumId; ?>" />

                    <div class="mb-2">
                        <label for="address"><strong>Address</strong> </label>
                        <input type="text" class="form-control" aria-label="address" name="address"
                            value="<?php echo $row['address_']; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label for="email"><strong>Email</strong> </label>
                        <input type="email" class="form-control" aria-label="email" name="email"
                            value="<?php echo empty($row['email']) ? NULL : $row['email']; ?>">
                    </div>

                    <label for="contactNumber"><strong>Mobile Number</strong> </label>
                    <div class="input-group">
                        <span class="input-group-text" id="contactx">+63</span>
                        <input type="text" id="contactNumber" name="contactNumber" class="form-control rounded-end-2"
                            value="<?php echo empty($row['contact_no']) ? NULL : $row['contact_no']; ?>"
                            aria-describedby="contactx" oninput="formatContactNumber(this)">
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="editContact" class="btn btn-sm btn-primary">Update Info</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function formatContactNumber(input) {
    var numericValue = input.value.replace(/\D/g, '');
    var limitedValue = numericValue.substring(0, 10);
    input.value = limitedValue;
}
</script>