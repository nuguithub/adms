<!-- Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnnouncementModalLabel">Add Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/addann-act.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Title" aria-label="Title" name="title">
                    </div>
                    <div class="form-control mb-3 text-start">
                        <label for="img">Choose Image</label>
                        <input type="file" class="form-control" name="img" accept="image/*" required>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" id="content" name="content" rows="5"
                            style="resize: none; font-size: 14px;" placeholder="Contents" required></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control datepicker" placeholder="Event Date"
                            aria-label="Event Date" name="event_date">
                    </div>
                    <div class="input-group mb-3">
                        <input type="time" class="form-control timepicker" placeholder="Event Time"
                            aria-label="Event Time" name="event_time">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Venue" aria-label="Venue" name="venue">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Organizer" aria-label="Organizer"
                            name="organizer">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Announcement</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>