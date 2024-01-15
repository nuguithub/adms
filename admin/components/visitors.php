<?php
include '../connectDB.php';

// Get the current date and the date for the previous day
$currentDate = date("Y-m-d");

// Calculate the total number of views from all days
$totalViewsQuery = "SELECT SUM(user_visit) + SUM(admin_visit) + SUM(alumni_visit) + SUM(coordinator_visit) AS totalViews FROM `visitor`";
$totalViewsResult = mysqli_query($conn, $totalViewsQuery);
$totalViewsRow = mysqli_fetch_assoc($totalViewsResult);
$totalViews = $totalViewsRow['totalViews'];

// Calculate the total views for the current month
$currentMonth = date("Y-m");
$monthlyViewsQuery = "SELECT SUM(user_visit) + SUM(admin_visit) + SUM(alumni_visit) + SUM(coordinator_visit) AS monthlyViews FROM `visitor` WHERE `date` LIKE '$currentMonth%'";
$monthlyViewsResult = mysqli_query($conn, $monthlyViewsQuery);
$monthlyViewsRow = mysqli_fetch_assoc($monthlyViewsResult);
$monthlyViews = $monthlyViewsRow['monthlyViews'];

// Calculate the total views for the previous month
$previousMonth = date("Y-m", strtotime("-1 month"));
$previousMonthlyViewsQuery = "SELECT SUM(user_visit) + SUM(admin_visit) + SUM(alumni_visit) + SUM(coordinator_visit) AS previousMonthlyViews FROM `visitor` WHERE `date` LIKE '$previousMonth%'";
$previousMonthlyViewsResult = mysqli_query($conn, $previousMonthlyViewsQuery);
$previousMonthlyViewsRow = mysqli_fetch_assoc($previousMonthlyViewsResult);
$previousMonthlyViews = $previousMonthlyViewsRow['previousMonthlyViews'];

// Fetch the total views for each role
$totalViewsUserQuery = "SELECT SUM(user_visit) AS totalUser FROM `visitor`";
$totalViewsAlumniQuery = "SELECT SUM(alumni_visit) AS totalAlumni FROM `visitor`";
$totalViewsAdminQuery = "SELECT SUM(admin_visit) AS totalAdmin FROM `visitor`";
$totalViewsCoordinatorQuery = "SELECT SUM(coordinator_visit) AS totalCoordinator FROM `visitor`";

$totalViewsUserResult = mysqli_query($conn, $totalViewsUserQuery);
$totalViewsAlumniResult = mysqli_query($conn, $totalViewsAlumniQuery);
$totalViewsAdminResult = mysqli_query($conn, $totalViewsAdminQuery);
$totalViewsCoordinatorResult = mysqli_query($conn, $totalViewsCoordinatorQuery);

$totalViewsUserRow = mysqli_fetch_assoc($totalViewsUserResult);
$totalViewsAlumniRow = mysqli_fetch_assoc($totalViewsAlumniResult);
$totalViewsAdminRow = mysqli_fetch_assoc($totalViewsAdminResult);
$totalViewsCoordinatorRow = mysqli_fetch_assoc($totalViewsCoordinatorResult);
?>

<style>
#reports tr td {
    text-align: center;
}
</style>

<div class="card overflow-auto shadow border-0 my-lg-5 my-2" style="background: #eee3;">
    <div class="mx-auto m-5" style="width: 80%;">
        <p class="fw-bold fs-4"><?php echo $monthlyViews = $monthlyViews ?? 0;;?> - Visits
            <span style="font-size: 14px;">as of <?php echo date("M Y", strtotime($currentDate)); ?></span>
        </p>
        <div class="d-lg-flex position-relative">
            <p class="mx-auto fs-1">
                <span style="font-size: 14px;">Total Visits:</span>
                <strong class="ps-5"><?php echo $totalViews = $totalViews ?? 0 ; ?></strong>
            </p>
            <p class="position-absolute me-0 fs-5 bottom-0 end-0 text-center">
                <span class="d-md-block d-none" style="font-size: 14px;">Previous Month:</span>
                <?php if ($monthlyViews > $previousMonthlyViews) { ?>
                <i class="fas fa-arrow-up text-success"></i>
                <?php
                } else { ?>
                <i class="fas fa-arrow-down text-danger"></i>
                <?php
                }
                ?>
                <strong><?php echo $previousMonthlyViews = $previousMonthlyViews ?? 0 ; ?></strong>
            </p>
        </div>
        <hr class="my-1" />
        <div class="mx-lg-5 px-lg-5">
            <table class="w-100 mt-3" id="reports">
                <tr>
                    <th>Total User Visits:</th>
                    <td><?php echo $totalViewsUserRow['totalUser'] = $totalViewsUserRow['totalUser'] ?? 0; ?></td>
                </tr>
                <tr>
                    <th>Total Alumni Visits:</th>
                    <td><?php echo $totalViewsAlumniRow['totalAlumni'] = $totalViewsAlumniRow['totalAlumni'] ?? 0; ?>
                    </td>
                </tr>
                <tr>
                    <th>Total Admin Visits:</th>
                    <td><?php echo $totalViewsAdminRow['totalAdmin'] = $totalViewsAdminRow['totalAdmin'] ?? 0; ?></td>
                </tr>
                <tr>
                    <th>Total Coordinator Visits:</th>
                    <td><?php echo $totalViewsCoordinatorRow['totalCoordinator'] = $totalViewsCoordinatorRow['totalCoordinator'] ?? 0; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>