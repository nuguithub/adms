<?php
require_once 'connectDB.php';

$announcement_id = isset($_GET['id']) ? $_GET['id'] : NULL;

if(!empty($announcement_id)) {
    $sql = "SELECT * FROM announcements WHERE announcement_id = $announcement_id ORDER BY CONCAT(event_date, ' ', event_time) DESC";
    $result = $conn->query($sql);
}
else {
    $sql = "SELECT * FROM `announcements` 
            ORDER BY CONCAT(event_date, ' ', event_time) DESC";
    $result = $conn->query($sql);
}



?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Announcements</title>
    <link rel="stylesheet" href="bootstrap/bs.css">
    <link rel="stylesheet" href="assets/dashboard.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Slab:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    .nav-ln:nth-child(2)::after {
        opacity: 1;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 my-3">

                <h1 class="fw-bold my-5">Announcements</h1>
                <hr>
                <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $title = $row['title'];
                            $img = $row['img'];
                            $description = $row['content'];
                            $event_date = date("D M j, Y", strtotime($row['event_date']));
                            $event_time = date("g:i A", strtotime($row['event_time']));
                            $event_venue = $row['venue'];
                            $person_in_charge = $row['organizer'];
                        ?>
                <h2 class="fw-bolder my-3"><?php echo $title; ?></h2>
                <?php
                    if (!empty($row['img'])) {
                        ?>
                <img src="img/announcement/<?php echo $row['img']; ?>" class="card-img-top w-100 object-fit-cover"
                    alt="News">
                <?php
                    } else {
                        ?>
                <img src="img/announcement/no-image.png" class="card-img-top w-100 object-fit-cover" alt="News">
                <?php
                    }
                        ?>

                <div class="row my-3">
                    <div class="col-xl-11">
                        <p class="fw-medium"><?php echo $description; ?></p>
                        <p class="text-secondary ms-5" style="font-size: 16px;">
                            <strong>Person in Charge:</strong>
                            <?php echo $person_in_charge; ?><br>
                            <strong>When: </strong><?php echo $event_time; ?> PHT, <?php echo $event_date; ?> <br>
                            <strong>Where: </strong><?php echo $event_venue; ?>
                        </p>
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
                <h3 class="fw-bold my-lg-5 mt-3">Other Announcements</h3>
                <?php

                if (isset($_GET['id'])) {
                    $excludeAnnouncementId = isset($_GET['id']) ? $_GET['id'] : NULL; // Set the announcement ID you want to exclude
                    $sql1 = "SELECT * FROM announcements WHERE announcement_id != $excludeAnnouncementId ORDER BY event_date DESC";
                } else {
                    $sql1 = "SELECT * FROM announcements ORDER BY event_date DESC";
                }
                
                $result1 = $conn->query($sql1);

                    if ($result1 && $result1->num_rows > 0) {
                        while ($rowx = $result1->fetch_assoc()) {
                            $titlx = $rowx['title'];
                            if (strlen($titlx) > 25) {
                                $titlx = substr($titlx, 0, 22) . "...";
                            }
                ?>
                <a href="announcement.php?id=<?php echo $rowx['announcement_id'];?>"><?php echo $titlx ;?></a><br />
                <?php
                        }
                    }
                ?>
                <a href="announcement.php">See all...</a>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="bootstrap/bs.js"></script>

</body>

</html>