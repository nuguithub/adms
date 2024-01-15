<section class="container section section-padding">
    <div class="container-fluid">
        <div class="container-fluid row">
            <div class="col-md text-center">
                <div class="section-header pb-5 news-title d-inline-block">
                    <h2>News</h2>
                </div>
            </div>
        </div>
        <div class="row">

            <?php
            require_once 'connectDB.php';

            $sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT 3";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dateObj = new DateTime($row['created_at']);
                        
                    $formattedDate = $dateObj->format('F j, Y g:i A');

                    $content = $row['content'];

                        if (strlen($content) > 77) {
                            $content = substr($content, 0, 77) . '...';
                        }

                        $title = $row['title'];

                        if (strlen($title) > 20) {
                            $title = substr($title, 0, 17) . '...';
                        }
            ?>
            <div class="col-12 col-md-6 col-lg-4 mb-2 mx-auto">
                <div class="shadow card mx-auto w-75 p-3">
                    <?php
                            if (!empty($row['img'])) {
                            ?>
                    <img src="img/news/<?php echo $row['img']; ?>" class="card-img-top rounded-2 object-fit-cover"
                        style="height: 8rem;">
                    <?php
                                    } else {
                                    ?>
                    <img src="img/news/no-image.png" class="card-img-top rounded-2 object-fit-cover"
                        style="height: 8rem;">
                    <?php
                                    }
                                    ?>
                    <div class="card-body" style="height: 8.5rem;">
                        <h5 class="card-title text-start fw-bolder"><?php echo $title; ?></h5>
                        <p class="card-text text-start"><?php echo $content; ?></p>
                    </div>

                    <p>
                        <strong>Author:</strong> <?php echo $row['author_name']; ?><br>
                        <strong>Published:</strong>
                        <?php echo $formattedDate; ?>
                    </p>

                    <div class="text-end px-1">
                        <a href="news.php?id=<?php echo $row['news_id'];?>"
                            class="text-success text-decoration-none">Read More<i
                                class="fas fa-long-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <?php
                    }
                } else {
                    echo '<p class="text-center">No News available</p>';
                }
            ?>

        </div>
    </div>
</section>