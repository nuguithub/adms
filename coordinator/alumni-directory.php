<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Directory</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    #nav-list li:nth-child(2) a {
        background-color: var(--color-white);
        border-radius: 5px;
    }

    #nav-list li:nth-child(2) a i,
    #nav-list li:nth-child(2) a span {
        color: var(--color-default);
    }

    #serts:focus {
        box-shadow: 0 0 #3330 !important;
        border: 1px solid #ddd;
    }
    </style>
</head>

<body>
    <main class="d-flex">
        <?php include "components/sidebar.php"; ?>

        <div class="home-section">

            <div class="card border-0 m-0 overflow-auto" style="max-height: 90vh;">
                <div class="alumni mx-3 my-3">
                    <div class="my-2">
                        <div class="d-flex justify-content-between">
                            <div class="mb-0">
                                <h2 class="fw-bolder ms-sm-3">Alumni Directory </h2>
                            </div>
                            <div class="d-flex align-items-end">
                                <form action="process_excel.php" method="post" enctype="multipart/form-data" hidden>
                                    <input type="file" name="excel_file" accept=".xlsx, .xls">
                                    <input type="submit" name="upload" value="Import file">
                                </form>

                                <a class="btn btn-primary btn-sm px-md-4 text-nowrap" href="#importExcel"
                                    data-bs-toggle="modal" data-bs-target="#importExcel"><i
                                        class="fal fa-upload me-1"></i>Import Excel</a>

                                <?php include 'actions/importExcel.php';?>
                            </div>
                        </div>

                    </div>
                    <?php if (!empty($message)) : ?>
                    <?php if ($message === "A") : ?>
                    <div class="alert alert-success alert-dismissible fade show" style="font-size: 14px;" role="alert">
                        Alumni added successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php else : ?>
                    <div class="alert alert-danger alert-dismissible fade show" style="font-size: 14px;" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php
                    if (isset($_SESSION['mess'])) {
                        $message = $_SESSION['mess'];
                        if($_SESSION['mess'] === "A") {
                            ?>
                    <div class="alert alert-success alert-dismissible fade show" style="font-size: 14px;" role="alert">
                        Alumni list imported successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                        }
                        else {
                            ?>
                    <div class="alert alert-info alert-dismissible fade show" style="font-size: 14px;" role="alert">
                        <?php echo is_array($message) ? implode('<br>', $message) : $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                        }
                        unset($_SESSION['mess']); 
                    }
                    ?>

                    <div class="table-responsive">
                        <form method="GET" action="">
                            <div class="ms-auto col-lg-12">
                                <div class="ms-auto col-lg-12 w-100">
                                    <div class="input-group my-2">
                                        <input class="form-control rounded-0" type="text" name="search_query" id="serts"
                                            placeholder="Search by Student Number, Last Name, Course Code" />
                                        <button class="rounded-0 btn btn-success px-5 z-0" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table table-responsive text-center table-striped">
                            <thead class="table-dark">
                                <th>Student Number</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Current Work</th>
                                <th>Employment Status</th>
                                <th>College Department</th>
                                <th>Course</th>
                                <th>Year Graduated</th>
                                <th>Actions</th>
                            </thead>
                            <tbody class="text-nowrap">

                                <?php
                                $searchQuery = isset($_GET['search_query']) ? mysqli_real_escape_string($conn, $_GET['search_query']) : '';

                                $itemsPerPage = 10;

                                $request = "SELECT a.*, wh.*, ap.*, d.dept_name, c.course_name,
                                                COALESCE(
                                                    (SELECT position
                                                    FROM workHistory
                                                    WHERE user_id = a.user_id AND work_id IS NOT NULL AND workEnd = 'Present'
                                                    LIMIT 1), 'No info') AS position,
                                                COALESCE(
                                                    (SELECT empStat
                                                    FROM workHistory
                                                    WHERE user_id = a.user_id AND workEnd = 'Present'
                                                    LIMIT 1), 'N/A') AS empStat
                                            FROM alumni a
                                            LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
                                            LEFT JOIN departments d ON ap.coll_dept = d.dept_code
                                            LEFT JOIN courses c ON ap.coll_course = c.course_code
                                            LEFT JOIN workHistory wh ON a.user_id = wh.user_id
                                            WHERE coll_dept = '$college'";
                                
                                if (!empty($searchQuery)) {
                                    $searchConditions = [];
                                    
                                    $searchConditions[] = "a.student_number LIKE '%$searchQuery%' OR a.lname LIKE '%$searchQuery%' OR ap.coll_dept = '$searchQuery' OR ap.coll_course = '$searchQuery'";
                                
                                    $searchCondition = implode(' OR ', $searchConditions);
                                
                                    $request .= " AND ($searchCondition)";
                                }
                                $request .= " GROUP BY a.alumni_id";

                                $searchResult = $conn->query($request); // Execute the query without LIMIT to count all matching items
                                $totalItems = $searchResult->num_rows;
                                $totalPages = ceil($totalItems / $itemsPerPage);

                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $start_item = ($current_page - 1) * $itemsPerPage;

                                $request .= " LIMIT $start_item, $itemsPerPage";
                                $result = $conn->query($request);

                                if ($result->num_rows > 0):
                                foreach ($result as $value): 
                                    
                                ?>

                                <tr class="align-middle">
                                    <td>
                                        <?php echo $value['student_number'];  ?>
                                    </td>
                                    <td>
                                        <?php echo $value['fname'];  ?>
                                    </td>
                                    <td>
                                        <?php echo $value['lname'];  ?>
                                    </td>
                                    <td><?php echo $value['gender']; ?></td>
                                    <td><?php 
                                        $birthdate = $value['birthday']; 

                                        $currentDate = date("Y-m-d");
                                        $age = date_diff(date_create($birthdate), date_create($currentDate))->y;
                                        echo $age; 
                                        ?>
                                    </td>
                                    <td><?php echo $value['position']; ?></td>
                                    <td><?php echo $value['empStat'] ?? '-'; ?></td>
                                    <td><?php echo $value['coll_dept']; ?></td>
                                    <td><?php echo $value['coll_course']; ?></td>
                                    <td><?php echo $value['batch']; ?></td>
                                    <td>
                                        <a href="#editAlumniModal_<?php echo $value['alumni_id']; ?>"
                                            class="btn btn-primary btn-sm px-3" data-bs-toggle="modal">Edit</a>
                                        <a class="btn btn-danger btn-sm px-3"
                                            href="actions/delAlumni.php?alumni_id=<?php echo $value['alumni_id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete this alumni?');">Delete</a>

                                        <?php include 'actions/edit_alumni.php'; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="11">
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
        </div>

    </main>

    <script src="../assets/sidebar.js"></script>
    <script src="../bootstrap/bs.js"></script>

</body>

</html>