<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewsModalLabel">Add News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/addnews-act.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Title" aria-label="Title" name="title">
                    </div>
                    <div class="form-control mb-3">
                        <label for="img">Choose Image</label>
                        <input type="file" class="form-control" name="img" accept="image/*" required>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" id="content" name="content" rows="10"
                            style="resize: none; font-size: 14px;" placeholder="Contents" required></textarea>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Author" aria-label="Author"
                            name="author_name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add News</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>