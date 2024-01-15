<?php 
session_start(); 
if ($_SESSION['role_'] === "alumni_admin") {
    $role = "Admin";
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
        <li>
            <a href="news.php">
                <i class="fal fa-newspaper"></i>
                <span class="link_name">News</span>
            </a>
            <span class="tooltip">News</span>
        </li>
        <li>
            <a href="announcement.php">
                <i class="fal fa-bullhorn"></i>
                <span class="link_name">Announcements</span>
            </a>
            <span class="tooltip">Announcements</span>
        </li>
        <li>
            <a href="course.php">
                <i class="fal fa-chalkboard-teacher"></i>
                <span class="link_name">Depts. & Courses</span>
            </a>
            <span class="tooltip">Departments & Courses</span>
        </li>
        <li>
            <a href="coordinator.php">
                <i class="fal fa-users"></i>
                <span class="link_name">Coordinators</span>
            </a>
            <span class="tooltip">Coordinators</span>
        </li>
        <li>
            <a href="reports.php">
                <i class="far fa-chart-bar"></i>
                <span class="link_name">Reports</span>
            </a>
            <span class="tooltip">Reports</span>
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
                    <div class="designation"><?php echo $role; ?></div>
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