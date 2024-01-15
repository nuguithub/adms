<?php 
    require_once '../connectDB.php';

    $newsQuery = "SELECT * FROM news WHERE news_id = ?";
    $stmt = mysqli_prepare($conn, $newsQuery);
    mysqli_stmt_bind_param($stmt, "i", $id); 
    mysqli_stmt_execute($stmt);
    $newsResult = mysqli_stmt_get_result($stmt);
    $newsData = mysqli_fetch_assoc($newsResult);
    mysqli_stmt_close($stmt);

?>
<div class="modal fade" id="editNewsModal_<?php echo $id; ?>" tabindex="-1"
    aria-labelledby="editNewsModalLabel_<?php echo $id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNewsModalLabel_<?php echo $id; ?>">Edit News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/update_news.php" method="post" enctype="multipart/form-data">

                    <input type="text" name="id" value="<?php echo $newsData['news_id']; ?>" hidden>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Title" aria-label="Title" name="title"
                            value="<?php echo $newsData['title']; ?>">
                    </div>
                    <div class="form-control mb-3 text-start">
                        <label for="img">Choose Image</label>
                        <input type="file" class="form-control" id="hero_img" name="img" accept="image/*">
                        <?php if (!empty($newsData['img'])) : ?>
                        <p><img src="../img/news/<?php echo $newsData['img']; ?>" alt="Hero Image" class="mt-2"
                                style="max-width: 100px;"> <?php echo $newsData['img']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" id="content" name="content" rows="5"
                            style="resize: none; font-size: 14px;"
                            placeholder="Contents"><?php echo $newsData['content']; ?></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control datepicker" placeholder="News Date"
                            aria-label="News Date" name="news_date"
                            value="<?php echo date("Y-m-d", strtotime($newsData['created_at'])); ?>">
                    </div>
                    <div class="input-group mb-3">
                        <input type="time" class="form-control timepicker" placeholder="News Time"
                            aria-label="News Time" name="news_time"
                            value="<?php echo date("H:i", strtotime($newsData['created_at'])); ?>">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Author" aria-label="Author" name="author"
                            value="<?php echo $newsData['author_name']; ?>">
                    </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update News</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>