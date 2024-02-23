<!-- Add this modal at the end of your importExcel.php file -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error During Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <div id="failedRecords" style="font-size: .8rem; max-height: 8rem; overflow-y: auto;">
                        <?php
                            // Check if session variable is set and not empty
                            if (isset($_SESSION['failedData']) && !empty($_SESSION['failedData'])) {
                                // Display the first 5 failed records
                                for ($i = 0; $i < min(5, count($_SESSION['failedData'])); $i++) {
                                    echo $_SESSION['failedData'][$i] . "<br>";
                                }
                            
                            ?>
                    </div>
                    <div class="text-end">
                        <?php 
                            if (count($_SESSION['failedData']) > 5) {
                        ?>
                        <a href="javascript:void(0);" id="seeMoreLink" onclick="showAllFailedRecords()"><em>See
                                more</em></a>
                        <a href="javascript:void(0);" id="seeLess" onclick="hideExtraFailedRecords()"
                            style="display: none;"><em>See less</em></a>
                        <?php } } ?>
                    </div>
                </div>
                <p class="m-0">Do you wish to continue?</p>
                <div class="text-secondary" style="font-size: .78rem">Note: <em>Proceeding will discard the erroneous
                        data during
                        the upload process.</em></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <a href="actions/saveUploadExcel.php" type="submit" class="btn btn-primary" name="confirmUpload">Yes</a>

            </div>
        </div>
    </div>
</div>

<script>
function showAllFailedRecords() {
    // Display all failed records
    var failedRecords = <?php echo json_encode($_SESSION['failedData']); ?>;
    var failedRecordsHtml = '';

    for (var i = 0; i < failedRecords.length; i++) {
        failedRecordsHtml += failedRecords[i] + "<br>";
    }

    document.getElementById('failedRecords').innerHTML = failedRecordsHtml;

    // Show "See Less" link
    document.getElementById('seeLess').style.display = 'inline';
    document.getElementById('seeMoreLink').style.display = 'none';
}

function hideExtraFailedRecords() {
    // Hide extra failed records
    var failedRecords = <?php echo json_encode($_SESSION['failedData']); ?>;
    var failedRecordsHtml = '';

    for (var i = 0; i < 5; i++) {
        failedRecordsHtml += failedRecords[i] + "<br>";
    }

    document.getElementById('failedRecords').innerHTML = failedRecordsHtml;

    // Show "See More" link
    document.getElementById('seeLess').style.display = 'none';
    document.getElementById('seeMoreLink').style.display = 'inline';
}
</script>