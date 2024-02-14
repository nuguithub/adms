<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Approval</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

            <div class="card border-0 m-0 overflow-auto" style="max-height: 90vh;">
                <div class="alumni mx-3 my-2">
                    <div class="mb-0">
                        <h2 class="fw-bolder ms-sm-3">
                            Alumni Approval
                        </h2>
                    </div>
                    <?php
                    if (isset($_SESSION["approveStat"])) {
                        // Retrieve the session message and status
                        list($message, $status) = $_SESSION["approveStat"];
                    
                        // Display the message
                        echo '<div class="alert alert-' . $status . ' alert-dismissible fade show" role="alert">' . $message .
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';

                    
                        // Unset or clear the session variable to avoid displaying it again
                        unset($_SESSION["approveStat"]);
                    }
                    ?>
                    <table class="table table-responsive text-center table-striped">
                        <thead class="table-dark text-nowrap">
                            <th>Image</th>
                            <th>Full Name</th>
                            <th>Sex</th>
                            <th>Course</th>
                            <th>Account Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                include '../connectDB.php'; 

                                $itemsPerPage = 10;
                                $request = "SELECT a.*, ap.*
                                            FROM alumni a
                                            JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
                                            WHERE a.user_id IS NOT NULL 
                                                AND ap.coll_dept = '$college'
                                            GROUP BY a.alumni_id
                                            ORDER BY a.approved";
         

                                $result = $conn->query($request);
                                $totalItems = $result->num_rows;
                                $totalPages = ceil($totalItems / $itemsPerPage);

                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $start_item = ($current_page - 1) * $itemsPerPage;

                                $request .= " LIMIT $start_item, $itemsPerPage";
                                $result = $conn->query($request);
                                
                                if ($result->num_rows > 0): 
                                foreach($result as $value):
                                ?>

                            <tr class="align-middle text-nowrap">
                                <td>
                                    <?php
                                if (!empty($value['img'])) {
                                    ?>
                                    <img src="../img/alumni/<?php echo $value['img']; ?>"
                                        class="card-img-top rounded-circle object-fit-cover"
                                        style="height: 50px; width:50px;">
                                    <?php
                                } else {
                                    ?>
                                    <img src="../img/alumni/no-image.png"
                                        class="card-img-top rounded-circle object-fit-cover"
                                        style="height: 50px; width:50px;">
                                    <?php
                                }
                                ?>
                                </td>
                                <td>
                                    <?php echo $value['fname'] . " " . $value['mname'] . " " . $value['lname']  ?>
                                </td>
                                <td><?php echo $value['gender'] ?></td>
                                <td><?php echo $value['coll_course']; ?></td>
                                <td>
                                    <?php
                                if ($value['approved'] === 'approved') {
                                    ?>
                                    <span class="badge text-bg-primary"><?php echo $value['approved']; ?></span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="badge text-bg-secondary">Pending</span>
                                    <?php
                                }
                                ?>
                                </td>
                                <td>
                                    <a class="btn btn-success <?php if ($value['approved'] === 'approved') echo 'disabled'; ?>"
                                        onclick="approveAlumni('<?php echo $value['user_id']; ?>')"
                                        data-id="<?php echo $value['user_id']; ?>">
                                        Approve
                                    </a>
                                    <script>
                                    function approveAlumni(user_id) {
                                        if (confirm("Are you sure you want to approve this alumni?")) {
                                            window.location.href = "actions/update_status.php?user_id=" + user_id;
                                        }
                                    }
                                    </script>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <p class="my-3">No matching records found.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php include 'components/pagination.php';?>

                </div>
            </div>

        </div>
    </main>

    <script src="../assets/sidebar.js"></script>
    <script src="../bootstrap/bs.js"></script>
</body>

</html>