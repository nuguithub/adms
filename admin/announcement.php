<?php
require_once '../connectDB.php';

    $itemsPerPage = 5;
    $request = "SELECT * FROM announcements ORDER BY announcement_id DESC";

    $result = $conn->query($request);
    $totalItems = $result->num_rows;
    $totalPages = ceil($totalItems / $itemsPerPage);

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_item = ($current_page - 1) * $itemsPerPage;

    $request .= " LIMIT $start_item, $itemsPerPage";
    $result = $conn->query($request);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcement</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    #nav-list li:nth-child(4) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(4) a i,
    #nav-list li:nth-child(4) a span {
        color: var(--color-default);
    }
    </style>
</head>

<body>
    <main class="d-flex">

        <?php include "components/sidebar.php"; ?>

        <div class="home-section">

            <div class="col m-auto">
                <div class="card m-3" style="background: #ccc; border: none;">
                    <div class="card-body overflow-auto" style="max-height: 90vh;">
                        <div class="mt-5 mx-5">
                            <h2 class="fw-bolder mb-3">Announcements</h2>
                            <div class="text-end">
                                <button type="button" class="btn btn-success px-3" data-bs-toggle="modal"
                                    data-bs-target="#addAnnouncementModal">Add Announcement</button>
                                <?php include 'actions/add_announcement.php';?>
                            </div>
                        </div>
                        <div class="row mx-5">
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['announcement_id'];
                                    $title = $row['title'];
                                    $description = $row['content'];
                                    $venue = $row['venue'];
                                    $date_posted = date("D M j, Y", strtotime($row['event_date']));
                                    $time_posted = date("g:i A", strtotime($row['event_time']));
                                    $organizer = $row['organizer'];
                                    ?>
                            <hr class="mt-3" />
                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                <?php
                                    if (!empty($row['img'])) {
                                        ?>
                                <img src="../img/announcement/<?php echo $row['img']; ?>"
                                    class="card-img w-100 object-fit-cover" alt="News">
                                <?php
                                    } else {
                                        ?>
                                <img src="../img/announcement/no-image.png" class="card-img w-100 object-fit-cover"
                                    alt="No available image for this announcement" style="height: 10vh;">
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="col-8 ps-lg-5 my-lg-auto my-3">
                                <p class="fs-3 fw-bold"><?php echo $title; ?></p>
                                <?php
                                    $maxLength = 100;

                                    if (strlen($description) > $maxLength) {
                                        $shortDescription = substr($description, 0, $maxLength) . '...';
                                    } else {
                                        $shortDescription = $description;
                                    }
                                ?>
                                <p class="fst-italic"><?php echo $shortDescription; ?></p>
                                <p><span class="fw-bold">When:</span> <?php echo $date_posted;?> at
                                    <?php echo $time_posted; ?> PHT <br>
                                    <span class="fw-bold">Where:</span> <?php echo $venue; ?></span>
                                    <br><span class="fw-bold">Organizer:</span>
                                    <?php echo $organizer; ?>
                                </p>
                            </div>

                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                <div class="d-flex flex-column m-3 w-100">

                                    <a href="#editAnnouncementModal_<?php echo $id; ?>"
                                        class="btn btn-primary btn-sm px-3 w-100" data-bs-toggle="modal">Edit</a>

                                    <?php include 'actions/edit_announcement.php';?>

                                    <a href="actions/delann-act.php?announcement_id=<?php echo $id; ?>"
                                        class="btn btn-danger btn-sm px-3 mt-2 w-100"
                                        onclick="return confirmDelete();">Delete</a>

                                    <script>
                                    function confirmDelete() {
                                        return confirm("Are you sure you want to delete this announcement?");
                                    }
                                    </script>
                                </div>
                            </div>
                            <?php
                                }
                                } else {
                                    echo '<hr class="mt-3" /><div class="col-12 text-center my-3">No announcement available.</div>';
                                }
                            ?>
                        </div>

                        <?php include 'components/pagination.php';?>

                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="../bootstrap/bs.js"></script>
    <script src="../assets/sidebar.js"></script>
</body>

</html>