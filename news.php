<?php
require_once 'connectDB.php';

$news_id = isset($_GET['id']) ? $_GET['id'] : NULL;

if(!empty($news_id)) {
    $sql = "SELECT * FROM news WHERE news_id = $news_id";
    $result = $conn->query($sql);
}
else {
    $sql = "SELECT * FROM news ORDER BY news_id DESC LIMIT 5";
    $result = $conn->query($sql);
}



?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>News</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link rel="stylesheet" href="assets/dashboard.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    .nav-ln:nth-child(3)::after {
        opacity: 1;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 my-3">
                <h1 class="fw-bold my-5">Latest News</h1>
                <hr>
                <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $title = $row['title'];
                            $description = $row['content'];
                            $date_posted = date("D M j, Y", strtotime($row['created_at']));
                            $time_posted = date("g:i A", strtotime($row['created_at']));
                            $author = $row['author_name'];
                            ?>
                <h2 class="fw-bolder my-3"><?php echo $title; ?></h2>
                <p class="text-secondary" style="font-size: 14px;">By <?php echo $author; ?><br>Posted
                    <?php echo $time_posted; ?> PHT,
                    <?php echo $date_posted; ?></p>
                <?php
                    if (!empty($row['img'])) {
                        ?>
                <img src="img/news/<?php echo $row['img']; ?>" class="card-img-top w-100 object-fit-cover" alt="News">
                <?php
                    } else {
                        ?>
                <img src="img/news/no-image.png" class="card-img-top w-100 object-fit-cover" alt="News">
                <?php
                    }
                        ?>

                <div class="row my-3">
                    <div class="col-xl-11">
                        <p class="fw-medium"><?php echo $description; ?></p>
                    </div>
                </div>
                <hr>
                <?php
                            }
                        } else {
                            echo '<div class ="position-absolute top-50 start-50 translate-middle">
                            <p>No news articles available.</p>
                            </div>';
                        }
                        ?>
                </tbody>
                </table>
            </div>
            <div class="col-lg-4 my-3 text-end">
                <h3 class="fw-bold my-lg-5 mt-3">Other News</h3>
                <?php
                
                if (isset($_GET['id'])) {
                    $excluded = isset($_GET['id']) ? $_GET['id'] : NULL;
                    $sql1 = "SELECT * FROM news WHERE news_id != $excluded ORDER BY created_at DESC";
                } else {
                    $sql1 = "SELECT * FROM news ORDER BY created_at DESC";
                }

                $result1 = $conn->query($sql1);

                    if ($result1 && $result1->num_rows > 0) {
                        while ($rowx = $result1->fetch_assoc()) {
                            $titlx = $rowx['title'];
                            if (strlen($titlx) > 12) {
                                $titlx = substr($titlx, 0, 12) . "...";
                            }
                ?>
                <a href="news.php?id=<?php echo $rowx['news_id'];?>"><?php echo $titlx ;?></a><br />
                <?php
                        }
                    }
                ?>
                <a href="news.php">See all...</a>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="bootstrap/bs.js"></script>
</body>

</html>