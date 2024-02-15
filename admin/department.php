<?php
include '../connectDB.php';

    $itemsPerPage = 5;
    $request = "SELECT * FROM departments ORDER BY dept_id";

    $result = $conn->query($request);
    $totalItems = $result->num_rows;
    $totalPages = ceil($totalItems / $itemsPerPage);

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_item = ($current_page - 1) * $itemsPerPage;

    $request .= " LIMIT $start_item, $itemsPerPage";
    $resultx = $conn->query($request);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <style>
    #nav-list li:nth-child(5) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(5) a i,
    #nav-list li:nth-child(5) a span {
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
                            <h2 class="fw-bolder mb-3"> Departments </h2>
                            <div class="text-end">
                                <a href="course.php" class="btn btn-warning px-3">Go to Course</a>
                                <button type="button" class="btn btn-success px-3" data-bs-toggle="modal"
                                    data-bs-target="#addDeptModal">Add Department</button>
                                <?php include 'actions/add_dept.php';?>
                            </div>
                            <hr>
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

                        </div>
                        <div class="row mx-5">

                            <div class="col-lg-9 mx-auto">
                                <div class="table-responsive">

                                    <table class="table">
                                        <?php
                                            if ($resultx->num_rows > 0) { ?>
                                        <thead class="text-nowrap">
                                            <tr class="h6 text-center">
                                                <th>Department Code</th>
                                                <th>Department Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                                while ($rowi = $resultx->fetch_assoc()) {
                                                    $dept_id = $rowi['dept_id'];
                                                    ?>
                                        <tbody class="text-nowrap">
                                            <tr class="text-center align-middle">

                                                <td><?php echo $rowi['dept_code']; ?></td>
                                                <td><?php echo $rowi['dept_name']; ?></td>

                                                <td class="d-flex justify-content-center">
                                                    <div class="d-flex flex-column w-100">
                                                        <a href="#editDeptModal_<?php echo $dept_id; ?>"
                                                            class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal">Edit</a>

                                                        <?php 
                                                         include 'actions/edit_dept.php'; ?>

                                                        <a href="actions/deldept-act.php?dept_id=<?php echo $dept_id; ?>"
                                                            class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirmDelete();">Delete</a>

                                                        <script>
                                                        function confirmDelete() {
                                                            return confirm(
                                                                "Are you sure you want to delete this dept?");
                                                        }
                                                        </script>
                                                    </div>
                                                </td>
                                                <?php
                                                    }
                                                } else {
                                                    echo '<div class="col-12 text-center mt-3">No data available.</div>';
                                                }
                                                ?>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
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