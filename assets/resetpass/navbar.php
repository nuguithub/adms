<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    } 
    include "log-modal.php";
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadows-nav sticky-top" id="nav">
    <div class="container">
        <a class="navbar-brand" href="../../dashboard.php#"><i class="icon fas fa-house-user me-3"></i>Alumni
            Manager</a>
        <div class="ms-auto">
            <ul class="navbar-nav navbar-text">

                <button class="btn btn-lg btn-outline-success fw-bold" type="button" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    Login
                </button>
            </ul>
        </div>
    </div>
</nav>