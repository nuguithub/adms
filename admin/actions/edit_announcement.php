<?php
    require_once '../connectDB.php';

    $announcementsQuery = "SELECT * FROM announcements WHERE announcement_id = ?";
    $stmt = mysqli_prepare($conn, $announcementsQuery);
    mysqli_stmt_bind_param($stmt, "i", $id); 
    mysqli_stmt_execute($stmt);
    $announcementsResult = mysqli_stmt_get_result($stmt);
    $announcementsData = mysqli_fetch_assoc($announcementsResult);
    mysqli_stmt_close($stmt);
    
?>

<!-- Modal -->
<div class="modal fade" id="editAnnouncementModal_<?php echo $id; ?>" tabindex="-1"
    aria-labelledby="editAnnouncementModalLabel_<?php echo $id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementModalLabel_<?php echo $id; ?>">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/update_announcement.php" method="post" enctype="multipart/form-data">

                    <input type="text" name="id" value="<?php echo $announcementsData['announcement_id']; ?>" hidden>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Title" aria-label="Title" name="title"
                            value="<?php echo $announcementsData['title']; ?>">
                    </div>
                    <div class="form-control mb-3 text-start">
                        <label for="img">Choose Image</label>
                        <input type="file" class="form-control" id="hero_img" name="img" accept="image/*">
                        <?php if (!empty($announcementsData['img'])) : ?>
                        <p><img src="../img/announcement/<?php echo $announcementsData['img']; ?>" alt="Hero Image"
                                class="mt-2" style="max-width: 100px;"> <?php echo $announcementsData['img']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" id="content" name="content" rows="5"
                            style="resize: none; font-size: 14px;"
                            placeholder="Contents"><?php echo $announcementsData['content']; ?></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control datepicker" placeholder="Event Date"
                            aria-label="Event Date" name="event_date"
                            value="<?php echo $announcementsData['event_date']; ?>">
                    </div>
                    <div class="input-group mb-3">
                        <input type="time" class="form-control timepicker" placeholder="Event Time"
                            aria-label="Event Time" name="event_time"
                            value="<?php echo $announcementsData['event_time']; ?>">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Venue" aria-label="Venue" name="venue"
                            value="<?php echo $announcementsData['venue']; ?>">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Organizer" aria-label="Organizer"
                            name="organizer" value="<?php echo $announcementsData['organizer']; ?>">
                    </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Announcement</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>