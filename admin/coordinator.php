<?php
    require_once '../connectDB.php';

    $itemsPerPage = 10;
    $request = "SELECT * FROM users WHERE role_ = 'college_coordinator'";

    $result = $conn->query($request);
    $totalItems = $result->num_rows;
    $totalPages = ceil($totalItems / $itemsPerPage);

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_item = ($current_page - 1) * $itemsPerPage;

    $request .= " LIMIT $start_item, $itemsPerPage";
    $result = $conn->query($request);

                    // Fetch department information
                    $que = "SELECT dept_code, dept_name FROM departments GROUP BY dept_code, dept_name";
                    $rslt = $conn->query($que);

                    $departments = [];

                    while ($rw = $rslt->fetch_assoc()) {
                        $departments[] = $rw;
                    }
                    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coordinator</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    #nav-list li:nth-child(6) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(6) a i,
    #nav-list li:nth-child(6) a span {
        color: var(--color-default);
    }

    table th,
    table td {
        background: none !important;
        border: none !important;
    }
    </style>
</head>

<body>
    <main class="d-flex">

        <?php 
            include "components/sidebar.php";
        ?>

        <div class="home-section">

            <div class="col m-auto">
                <div class="card m-3" style="background: #ccc; border: none;">
                    <div class="card-body overflow-auto" style="max-height: 90vh;">
                        <div class="mt-5 mx-5">
                            <h2 class="fw-bolder mb-3">
                                Coordinator
                            </h2>
                            <div class="text-end">
                                <button type="button" class="btn btn-success px-3" data-bs-toggle="modal"
                                    data-bs-target="#addCoordinatorModal">Add Coordinator</button>
                                <?php include 'actions/add_coordinator.php';?>
                            </div>
                            <?php

                            if(isset($_SESSION['coor_stat'])) {
                                if($_SESSION['coor_stat'] !== "B")
                                { ?>

                            <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                                <?php echo $_SESSION['coor_stat']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                            <?php
                                    unset($_SESSION['coor_stat']);
                                }
                                else { ?>

                            <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                                Coordinator added successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                            <?php
                                    unset($_SESSION['coor_stat']);
                                }
                            }
                            ?>
                            <hr>
                        </div>
                        <div class="row mx-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="h5 text-center">
                                            <th>Username</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['user_id'];
                                                $username = $row['username'];
                                            ?>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center align-middle">

                                            <td class=""><?php echo $username; ?></td>
                                            <td class="d-flex justify-content-center">
                                                <div class="w-50">
                                                    <a href="actions/delcoor-act.php?user_id=<?php echo $id; ?>"
                                                        class="btn btn-danger btn-sm px-3 w-auto"
                                                        onclick="return confirmDelete();">Delete</a>

                                                    <script>
                                                    function confirmDelete() {
                                                        return confirm(
                                                            "Are you sure you want to delete this coordinator?");
                                                    }
                                                    </script>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<div class="col-12 text-center mt-3">There is no coordinator.</div>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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