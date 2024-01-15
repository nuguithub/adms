<html>

<head>
    <title>Alumni Directory</title>
    <link rel="stylesheet" href="bootstrap/bs.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="text-center mt-5">View Alumni Members</h1>
        <div class="table-responsive mt-5">
            <table class="table table-striped table-bordered ">
                <thead class="table table-success align-middle text-nowrap">
                    <tr>
                        <th class="px-3">Alumni ID</th>
                        <th class="px-3" onclick="sortTable(1)">Registration No.</th>
                        <th class="px-3">Full Name</th>
                        <th class="px-3">Gender</th>
                        <th class="px-3">Civil Status</th>
                        <th class="px-3">Birthday</th>
                        <th class="px-5">Address</th>
                        <th class="px-3">Contact No.</th>
                        <th class="px-3">College Department</th>
                        <th class="px-3">Course</th>
                        <th class="px-3">Academic Year</th>
                        <th class="px-3">Email</th>
                        <th class="px-3">Works At</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <td>1</td>
                        <td>REG001</td>
                        <td>John Doe</td>
                        <td>Male</td>
                        <td>Single</td>
                        <td>1990-08-15</td>
                        <td>123 Main Street, City</td>
                        <td>123-456-7890</td>
                        <td>Computer Science</td>
                        <td>Computer Engineering</td>
                        <td>2010-2014</td>
                        <td>john.doe@example.com</td>
                        <td>ABC Corporation</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-3">
                <!-- Pagination links will be generated here -->
            </ul>
        </nav>
        <p class="text-center mt-5">
            <a class="btn btn-secondary" href="#">Back</a>
        </p>
    </div>

    <script src="bootstrap/bs.js"></script>

</body>

</html>