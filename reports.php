<div class="container">
    <div class="my-5 py-5 shadow" style="background: #fff;">
        <div class="row">
            <div class="col-md text-center">
                <div class="section-header pb-5 title-a-ln d-inline-block">
                    <h2>Reports and Statistics</h2>
                </div>
            </div>
        </div>
        <div class="row mx-auto">

            <?php
            require_once 'connectDB.php';

            $sql = "SELECT 
                        MAX(ap.batch) AS current_year,
                        COUNT(DISTINCT a.alumni_id) AS current_alumni,
                        COUNT(CASE WHEN a.approved = 'approved' THEN a.user_id END) AS user_count,
                        COUNT(DISTINCT a.alumni_id) AS alumni_count
                    FROM alumni a
                    LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
                    WHERE ap.batch = (SELECT MAX(batch) FROM alumni)";


            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                function formatCount($count) {
                    $roundedCount = round($count, -3);
                    return ($roundedCount > 1000) ? number_format($roundedCount, 0, '.', ',') . '+' : $count;
                }
                
                $alumniCount = $row['alumni_count'];
                $formattedAlumCount = formatCount($alumniCount);
                
                $userCount = $row['user_count'];
                $formattedMemCount = formatCount($userCount);
                
                $currentAlum = $row['current_alumni'];
                $formattedCurrCount = formatCount($currentAlum);
                
            ?>

            <div class="col-10 mx-auto">
                <div class="row" id="stats">
                    <style>
                    #stats div h1 {
                        background: -webkit-linear-gradient(left, var(--accent-color), var(--main-color));
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                    }
                    </style>
                    <div class="col-4 mx-auto text-center">
                        <h1 class="fw-bolder"><?php echo $formattedAlumCount; ?></h1>
                        <span class="fs-6">Total <strong>Number</strong> of Alumni</span>
                    </div>
                    <div class="col-4 mx-auto text-center">
                        <h1 class="fw-bolder"><?php echo $formattedMemCount; ?></h1>
                        <span class="fs-6"><strong>Registered</strong> Alumni</span>
                    </div>
                    <div class="col-4 mx-auto text-center">
                        <h1 class="fw-bolder"><?php echo $formattedCurrCount; ?></h1>
                        <span class="fs-6">Total Number of Alumni from Batch
                            <strong><?php echo $row['current_year']; ?></strong></span>
                    </div>
                </div>
            </div>

            <?php
            } else {
                echo '<p class="text-center">No data available</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>