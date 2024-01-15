<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "log-modal.php";
    include "reg-modal.php";
    
    $loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true; 
    $role = $loggedIn && isset($_SESSION['role_']) ? $_SESSION['role_'] : '';

?>
<style>
.active {
    font-weight: 700;
    color: #fff !important;
}

.show>>.log {
    font-weight: 700;
    color: #fff !important;
}

.dropdown:hover .fa-cog {
    animation: spin 2s linear infinite;
}

.dropdown:hover {
    font-weight: 700;
    color: #fff !important;
}
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadows-nav sticky-top">
    <div class="container p-4">
        <a class="navbar-brand" href="dashboard.php#"><i class="icon fas fa-house-user me-3"></i>Alumni Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="mx-2 nav-ln nav-item active">
                    <a class="nav-link" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="mx-2 nav-ln nav-item">
                    <a class="nav-link" href="announcement.php">Announcements</a>
                </li>
                <li class="mx-2 nav-ln nav-item">
                    <a class="nav-link" href="news.php">News</a>
                </li>
            </ul>

            <ul class="navbar-nav navbar-text">
                <?php if ($loggedIn): ?>
                <li class="dropdown nav-item">
                    <button class="btn btn-outline-success font-weight-bold" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="far fa-cog me-1"></i> Settings
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <?php
                            if ($role === "alumni") { ?>

                        <li><a class="dropdown-item mb-1" href="profile.php"><i class="far fa-user-circle me-2"></i>
                                Profile</a></li>
                        <li><a class="dropdown-item mb-1" href="account-settings.php"><i class="far fa-key me-2"></i>
                                Account-Settings</a></li>

                        <?php
                            } elseif ($role === "college_coordinator") { ?>

                        <li><a class="dropdown-item mb-1" href="coordinator/"><i class="far fa-table me-2"></i>
                                Dashboard</a></li>

                        <?php
                            } elseif ($role === "super_admin") { ?>

                        <li><a class="dropdown-item mb-1" href="superadmin/"><i class="far fa-table me-2"></i>
                                Dashboard</a></li>

                        <?php
                            } elseif ($role === "alumni_admin") { ?>

                        <li><a class="dropdown-item mb-1" href="admin/"><i class="far fa-table me-2"></i>
                                Dashboard</a></li>

                        <?php
                            }
                        ?>

                        <li class="nav-item">
                            <a class="dropdown-item text-danger" href="#" onclick="confirmLogout()"
                                style="font-weight: 600;"><i class="far fa-sign-out-alt me-2"></i>
                                Logout</a>
                        </li>
                    </ul>

                </li>
                <?php else: ?>
                <li class="nav-item">
                    <button class="btn btn-lg btn-outline-success fw-bold" type="button" data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        Login
                    </button>
                    <button class="btn-lg btn btn-warning text-light fw-bold" type="button" data-bs-toggle="modal"
                        data-bs-target="#disclaimerModal">Register
                    </button>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "logout-act.php";
    }
}
</script>