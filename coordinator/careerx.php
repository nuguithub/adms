<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Alumni</title>
    <link rel="stylesheet" href="../bootstrap/bs.css">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

        <?php include "components/sidebar.php"; 
        
        include_once '../connectDB.php';
        
        if (isset($_GET['course_code'])) {
            $courseCode = $_GET['course_code'];
        } else {
            header('Location: career.php');
            end();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit'])) {
                $careerName = $_POST['career-name'];
        
                $careerName = ucwords($careerName);
        
                $checkQuery = "SELECT * FROM careers WHERE career_name = ?";
                $stmtCheck = $conn->prepare($checkQuery);
                $stmtCheck->bind_param('s', $careerName);
                $stmtCheck->execute();
                $result = $stmtCheck->get_result();
        
                if ($result->num_rows > 0) {
                    $error_message = "Career Name: " . $careerName . " already exists!";
                } else {
                    try {
                        $insertQuery = "INSERT INTO careers (career_name, department, course) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($insertQuery);
                        $stmt->bind_param('sss', $careerName, $college, $courseCode); // Bind both career name and department code
                        $stmt->execute();
                        $success_message = "Career Name: " . $careerName . " added successfully!";
                    } catch (Exception $e) {
                        $error_message = "Error: " . $e->getMessage();
                    }
                }
                $stmtCheck->close();
            }
        }
        
        ?>

        <div class="home-section">
            <div class="card border-0 m-0 overflow-auto" style="max-height: 90vh;">

                <h3 class="ms-5 my-3 fw-bold"><?php echo $courseCode?> - Careers</h3>
                <div class="button-add-student">
                    <div class="text-end my-2">
                        <button type="button" class="btn btn-info me-1" data-bs-toggle="modal"
                            data-bs-target="#addCareerModal" data-bs-whatever="@mdo"><i
                                class="fas fa-briefcase me-2"></i>Add Career</button>
                        <a href="javascript:history.back()" class="btn btn-danger me-3"><i
                                class="fas fa-school me-2"></i>Courses</a>
                    </div>
                    <!-- Modal for Career -->
                    <div class="modal fade" id="addCareerModal" tabindex="-1" aria-labelledby="addCareerModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCareerModalLabel">Add Career</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <label for="career-name" class="col-form-label">Career Name:</label>
                                        <input type="text" class="form-control" id="career-name" name="career-name">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Add Career</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="careers mx-3">
                    <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger py-2"><?php echo $error_message ?></div>
                    <?php endif ?>
                    <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success py-2"><?php echo $success_message ?></div>
                    <?php endif ?>

                    <table class="table table-responsive text-center">
                        <thead class="table-dark">
                            <th>Career Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            include '../connectDB.php'; 

                            $itemsPerPage = 8;
                            $request = "SELECT * FROM careers WHERE related = 'YES' AND department = '$college' AND course = '$courseCode'";      

                            $result = $conn->query($request);
                            $totalItems = $result->num_rows;
                            $totalPages = ceil($totalItems / $itemsPerPage);

                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start_item = ($current_page - 1) * $itemsPerPage;

                            $request .= " LIMIT $start_item, $itemsPerPage";
                            $result = $conn->query($request);

                            if ($result->num_rows > 0) {
                                while ($value = $result->fetch_assoc()):
                            ?>
                            <tr class="align-middle">
                                <td class="p-1">
                                    <input id="career_<?php echo $value['career_id'] ?>" type="text" name="career-name"
                                        class="form-control text-center" value="<?php echo $value['career_name'] ?>"
                                        disabled>
                                </td>

                                <td class="p-1">
                                    <button id="edit_<?php echo $value['career_id'] ?>"
                                        class="btn btn-primary col-12 col-lg-6 btn-sm text-nowrap"
                                        onclick="editCareer(<?php echo $value['career_id'] ?>)">Edit</button>
                                    <form method="POST">
                                        <button id="save_<?php echo $value['career_id'] ?>"
                                            class="btn btn-success col-12 col-lg-6 btn-sm text-nowrap"
                                            style="display:none"
                                            onclick="saveCareer(<?php echo $value['career_id'] ?>)">Save</button>
                                    </form>
                                    <a href="actions/delcar-act.php?career_id=<?php echo $value['career_id']; ?>"
                                        class="btn btn-danger col-12 col-lg-6 btn-sm mt-1 text-nowrap"
                                        onclick="return confirmDelete();">Delete
                                    </a>
                                </td>
                            </tr>
                            <?php
                            endwhile;
                        } else {
                            echo '<tr><td colspan="3" class="py-5 my-5">No data available</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>

                    <?php include 'components/pagination.php';?>

                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap/script.js"></script>
    <script src="../bootstrap/bs.js"></script>
    <script src="actions/edit-career.js"></script>
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this career?");
    }
    </script>
</body>

</html>