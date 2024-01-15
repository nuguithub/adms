<?php
include '../connectDB.php';

    $itemsPerPage = 5;
    $request = "SELECT courses.*, departments.dept_code
            FROM courses
            INNER JOIN departments ON courses.department_id = departments.dept_id
            ORDER BY courses.department_id";

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
    <meta http-equiv="X-UA-Compatible" course_name="IE=edge">
    <meta name="viewport" course_name="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
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
                            <h2 class="fw-bolder mb-3">Courses </h2>
                            <div class="text-end">
                                <a href="department.php" class="btn btn-warning px-3">Go to Departments</a>
                                <button type="button" class="btn btn-success px-3" data-bs-toggle="modal"
                                    data-bs-target="#addCourseModal">Add Course</button>
                                <?php include 'actions/add_course.php';?>
                            </div>
                            <hr>
                            <?php
                            if (isset($_SESSION['mess'])) {
                                $succMess = $_SESSION['mess']; ?>

                            <div class="alert alert-success py-2"><?php echo $succMess; ?></div>

                            <?php
                                unset($_SESSION['mess']);
                            } else if (isset($_SESSION['messx'])) {
                                $errorMess = $_SESSION['messx']; ?>

                            <div class="alert alert-danger py-2"><?php echo $errorMess; ?></div>

                            <?php
                                unset($_SESSION['messx']);
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
                                                <th>Department</th>
                                                <th>Course Code</th>
                                                <th>Course Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                                while ($row = $resultx->fetch_assoc()) {
                                                    $course_id = $row['course_id'];
                                                    ?>
                                        <tbody class="text-nowrap">
                                            <tr class="text-center align-middle">

                                                <td><?php echo $row['dept_code']; ?></td>
                                                <td><?php echo $row['course_code']; ?></td>
                                                <td><?php echo $row['course_name']; ?></td>

                                                <td class="d-flex justify-content-center">
                                                    <div class="d-flex flex-column w-100">
                                                        <a href="#editCourseModal_<?php echo $course_id; ?>"
                                                            class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal">Edit</a>

                                                        <?php include 'actions/edit_course.php'; ?>

                                                        <a href="actions/delcourse-act.php?course_id=<?php echo $course_id; ?>"
                                                            class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirmDelete();">Delete</a>

                                                        <script>
                                                        function confirmDelete() {
                                                            return confirm(
                                                                "Are you sure you want to delete this course?");
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