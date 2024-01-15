<?php
    include '../connectDB.php';

    $itemsPerPage = 10;
?>


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
        <?php 
            include "components/sidebar.php";
        ?>

        <div class="home-section">
            <div class="card border-0 m-0" style="max-height: 90vh;">

                <div class="alumni mx-3 my-3">
                    <h2 class="fw-bolder mb-3 ms-sm-3 text">
                        Alumni Directory
                    </h2>

                    <form method="GET" action="">
                        <div class="ms-auto col-lg-6 w-100">
                            <div class="input-group my-2">
                                <input class="form-control rounded-0" type="text" name="search_query" id="serts"
                                    placeholder="Search by Student Number, Last Name, Course Code, or Department Code" />
                                <button class="rounded-0 btn btn-success px-5 z-0" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="table table-responsive w-100">
                        <table class="table text-center table-striped">
                            <thead class="table-dark text-nowrap">
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
                                            LEFT JOIN workHistory wh ON a.user_id = wh.user_id";
                                
                                if (!empty($searchQuery)) {
                                    $searchConditions = [];
                                    
                                    $searchConditions[] = "a.student_number LIKE '%$searchQuery%' OR a.lname LIKE '%$searchQuery%' OR ap.coll_dept = '$searchQuery' OR ap.coll_course = '$searchQuery'";
                                    
                                    $searchCondition = implode(' OR ', $searchConditions);
                                    
                                    $request .= " WHERE ($searchCondition)";
                                }
                                $request .= " GROUP BY a.alumni_id";
                                                                
                                $result = $conn->query($request);
                                
                                $totalItems = $result->num_rows;
                                $totalPages = ceil($totalItems / $itemsPerPage);
                                
                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $start_item = ($current_page - 1) * $itemsPerPage;
                                
                                $request .= " LIMIT $start_item, $itemsPerPage";
                                $result = $conn->query($request);
                                ?>

                                <?php if ($result->num_rows > 0): ?>
                                <?php foreach ($result as $value): ?>
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
                            ?></td>
                                    <td><?php echo $value['position']; ?></td>
                                    <td><?php echo $value['empStat'] ?? '-'; ?></td>
                                    <td><?php echo $value['coll_dept']; ?></td>
                                    <td><?php echo $value['coll_course']; ?></td>
                                    <td><?php echo $value['batch']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="10">
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

    <script src="../bootstrap/bs.js"></script>
    <script src="../assets/sidebar.js"></script>

</body>

</html>