<div class="container-fluid">
    <div class="row text-center mx-auto">
        <div class="col-md text-center">
            <div class="section-header pb-5 title-a-ln d-inline-block">
                <h2>Announcements</h2>
            </div>
        </div>
    </div>
    <div class="row">

        <?php
        require_once 'connectDB.php';

        $sql = "SELECT * FROM announcements WHERE CONCAT(event_date, ' ', event_time) > UTC_TIMESTAMP() ORDER BY CONCAT(event_date, ' ', event_time) DESC LIMIT 3";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $content = $row['content'];

                if (strlen($content) > 77) {
                    $content = substr($content, 0, 77) . '...';
                }

                $title = $row['title'];

                if (strlen($title) > 30) {
                    $title = substr($title, 0, 27) . '...';
                }
                ?>

        <div class="col-12 col-md-6 col-lg-4 mx-auto">
            <div class="card" style="">
                <?php
                if (!empty($row['img'])) {
                    ?>
                <img src="img/announcement/<?php echo $row['img']; ?>" class="card-img-top object-fit-cover"
                    style="height: 13rem;">
                <?php
                } else {
                    ?>
                <img src="img/announcement/no-image.png" class="card-img-top object-fit-cover" style="height: 13rem;">
                <?php
                }
                ?>
                <div class="card-body" style="height: 10rem;">
                    <h5 class="card-title text-left fw-bolder"><?php echo $title; ?></h5>
                    <p class="card-text text-left"><?php echo $content; ?></p>
                    <div class="text-end px-1">
                        <a href="announcement.php?id=<?php echo $row['announcement_id'];?>"
                            class="text-success text-decoration-none">Read More<i
                                class="fas fa-long-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
            }
        } else {
            echo '<p class="text-center">No data available</p>';
        }
        ?>

    </div>
</div>