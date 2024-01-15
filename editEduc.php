<?php
    include 'connectDB.php';

    $sql = "SELECT a.*, aa.*, ap.*
        FROM alumni a 
        LEFT JOIN achievements aa ON a.alumni_id = aa.alumni_id
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

<div class="modal fade" id="editEducModal_<?php echo $alumId; ?>" aria-hidden="true"
    aria-labelledby="editEducModalToggleLabel_<?php echo $alumId; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editEducModalToggleLabel_<?php echo $alumId; ?>">Education</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">

                <input type="hidden" name="id" value="<?php echo $alumId; ?>" />

                <div class="mb-2">
                    <label for="civil_status" class="mb-0 fs-6 fw-semibold">Programme</label>
                    <input type="text" class="form-control" value="<?php echo $row['coll_course'];?>" disabled>
                </div>
                <div class="mb-2">
                    <label for="civil_status" class="form-label mb-0 fs-6 fw-semibold">Batch</label>
                    <input type="text" class="form-control" value="<?php echo $row['batch'];?>" disabled>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <label for="civil_status" class="form-label mb-0 fs-6 fw-semibold">Achievements</label>
                        <a href="#addAchieveModal_<?php echo $alumId; ?>" data-bs-toggle="modal"
                            class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                            style="font-size: .8em;">Add</a>
                    </div>
                    <?php
                        $query = "SELECT * FROM achievements WHERE alumni_id = '$alumId'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            echo '<ul class="">';
                            
                            while ($achievementRow = mysqli_fetch_assoc($result)) {
                                $achievementValue = empty($achievementRow['achievement']) ? 'No data available' : $achievementRow['achievement'];
                                $dateAcquired = date('F, Y', strtotime($achievementRow['date']));
                                $dateValue_ = empty($dateAcquired) ? '' : ' (' . $dateAcquired . ')';
                                echo '<li class="text-secondary" style="font-size: 16px;">' . $achievementValue . $dateValue_ . '</li>';
                            }

                            echo '</ul>';
                        } else {
                            echo '<p class="text-center">No data available.</p>';
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>