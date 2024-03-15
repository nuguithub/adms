<?php
    require_once '../connectDB.php';

    $itemsPerPage = 5;
    $request = "SELECT * FROM news ORDER BY news_id DESC";

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
    <title>Manage News</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    #nav-list li:nth-child(3) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(3) a i,
    #nav-list li:nth-child(3) a span {
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
                            <h2 class="fw-bolder mb-3">News</h2>
                            <?php

                            if (isset($_SESSION['alert'])) {
                                $message = $_SESSION['alert'][0]; 
                                $status = $_SESSION['alert'][1];  

                                echo '<div class="alert alert-' . $status . ' alert-dismissible fade show" role="alert">' . $message . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                unset($_SESSION['alert']);
                            }
                            ?>
                            <div class="text-end">
                                <button type="button" class="btn btn-success px-3" data-bs-toggle="modal"
                                    data-bs-target="#addNewsModal">Add News</button>
                                <?php include 'actions/add_news.php';?>
                            </div>
                        </div>
                        <div class="row mx-5">
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['news_id'];
                                    $title = $row['title'];
                                    $description = $row['content'];
                                    $date_posted = date("F j, Y", strtotime($row['created_at']));
                                    $time_posted = date("g:i A", strtotime($row['created_at']));
                                    $author = $row['author_name'];
                                    ?>
                            <hr class="mt-3" />
                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                <?php
                                    if (!empty($row['img'])) {
                                        ?>
                                <img src="../img/news/<?php echo $row['img']; ?>"
                                    class="card-img w-100 object-fit-cover" alt="News">
                                <?php
                                    } else {
                                        ?>
                                <img src="../img/news/no-image.png" class="card-img w-100 object-fit-cover"
                                    alt="No available image for this news" style="height: 10vh;">
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
                                <p><strong>By:</strong> <?php echo $author;?> /
                                    <?php echo $time_posted . ' PHT ' . $date_posted; ?> </p>

                            </div>

                            <div class="col-12 col-lg-2 d-flex align-items-center">
                                <div class="d-flex flex-column m-3 w-100">

                                    <a href="#editNewsModal_<?php echo $id; ?>"
                                        class="btn btn-primary btn-sm px-3 w-100" data-bs-toggle="modal">Edit</a>

                                    <?php include 'actions/edit_news.php'; ?>

                                    <a href="actions/delnews-act.php?news_id=<?php echo $id; ?>"
                                        class="btn btn-danger btn-sm px-3 mt-2 w-100"
                                        onclick="return confirmDelete();">Delete</a>

                                    <script>
                                    function confirmDelete() {
                                        return confirm("Are you sure you want to delete this news?");
                                    }
                                    </script>
                                </div>
                            </div>
                            <?php
                                }
                            } else {
                                echo '<hr class="mt-3"/><div class="col-12 text-center my-3">No news available.</div>';
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