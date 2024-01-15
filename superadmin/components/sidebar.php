<?php 
session_start(); 
if ($_SESSION['role_'] === "super_admin") {
    $role = "Superadmin";
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
            <a href="accounts.php">
                <i class="far fa-user-cog"></i>
                <span class="link_name">Manage Accounts</span>
            </a>
            <span class="tooltip">Manage Accounts</span>
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