<?php 
session_start(); 
$college = "";
if ($_SESSION['role_'] === "college_coordinator") {
    $role = "Coordinator";
    $college = $_SESSION['college'];
} else {
    header('Location: ../logout-act.php');
    exit;
}
?>

<div class="sidebar">
    <div class="logo_details">
        <i class="far fa-graduation-cap icon"></i>
        <div class="logo_name">Alumni Manager</div>
        <i class="fas fa-bars" id="btn"></i>
    </div>
    <ul id="nav-list">
        <li>
            <a href="../dashboard.php">
                <i class="fal fa-house"></i>
                <span class="link_name">Homepage</span>
            </a>
            <span class="tooltip">Homepage</span>
        </li>
        <li>
            <a href="alumni-directory.php">
                <i class="fal fa-user-graduate"></i>
                <span class="link_name">Alumni Directory</span>
            </a>
            <span class="tooltip">Alumni Directory</span>
        </li>
        <?php
            require_once '../connectDB.php';

            $pendingApprovalQuery = "SELECT COUNT(*) AS pending_count 
                        FROM alumni a
                        JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
                        WHERE a.user_id IS NOT NULL 
                            AND (a.approved IS NULL OR a.approved != 'approved') 
                            AND ap.coll_dept = '$college'";

            $result = mysqli_query($conn, $pendingApprovalQuery);

            $pendingCount = 0;
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $pendingCount = $row['pending_count'];
            } 
            // else {
            //     // Handle the case where there's an error in the query
            //     echo "Error: " . mysqli_error($conn);
            // }
            ?>
        <li>
            <a class="position-relative" href="alumni.php">
                <i class="far fa-user-check"></i>
                <span class="link_name">Alumni Approval</span>
                <?php if ($pendingCount > 0) : ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo $pendingCount; ?>
                    <span class="visually-hidden">pending approval</span>
                </span>
                <?php endif; ?>
            </a>
            <span class="tooltip">Alumni Approval</span>
        </li>
        <li>
            <a href="career.php">
                <i class="far fa-briefcase"></i>
                <span class="link_name">Career</span>
            </a>
            <span class="tooltip">Career</span>
        </li>
        <li>
            <a href="account-settings.php">
                <i class="fal fa-user-circle"></i>
                <span class="link_name">Account Settings</span>
            </a>
            <span class="tooltip">Account Settings</span>
        </li>

        <li class="profile">
            <div class="profile_details">
                <i class="fas fa-user-circle"></i>
                <div class="profile_content">
                    <div class="name"><?php echo $_SESSION['username']; ?></div>
                    <?php 
                    if(empty($college)) {
                        ?>
                    <div class="designation"><?php echo $role; ?></div>
                    <?php
                    } else {
                        ?>
                    <div class="designation"><?php echo $college . ' ' . $role; ?></div>
                    <?php
                    }
                    ?>
                </div>
                <i class="far fa-sign-out-alt" id="log_out" onclick="confirmLogout()"></i>
            </div>

        </li>
    </ul>
</div>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "../logout-act.php";
    }
}
</script>