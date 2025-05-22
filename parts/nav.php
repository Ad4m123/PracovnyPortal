<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'functions.php';
global $pozdrav;
// Logged in ?
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';


?>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="images/logo.png" class="img-fluid logo-image">
            <div class="d-flex flex-column">
                <strong class="logo-text">Gotto</strong>
                <small class="logo-slogan">Online Job Portal</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-center ms-lg-5">
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>" href="index.php">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'about' ? 'active' : '' ?>" href="about.php">About Gotto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'job-listings' ? 'active' : '' ?>" href="job-listings.php">Job Listing</a>
                </li>
                
                <?php if (!$isLoggedIn): ?>
                    <!-- For users without account -->
                    <li class="nav-item ms-lg-auto">
                        <a class="nav-link <?= $activePage === 'register' ? 'active' : '' ?>" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-btn btn <?= $activePage === 'login' ? 'active' : '' ?>" href="login.php">Login</a>
                    </li>
                <?php else: ?>
                    <!--For logged in users -->
                    <li class="nav-item ms-lg-auto dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <?= $pozdrav ?>, <?= $userName ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light">
                            <li><a class="dropdown-item" href="liked.php">Liked</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>