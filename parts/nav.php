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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($activePage, ['jobs', 'job-details']) ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown">
                        Pages
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light">
                        <li><a class="dropdown-item <?= $activePage === 'jobs' ? 'active' : '' ?>" href="job-listings.php">Job Listings</a></li>
                        <li><a class="dropdown-item <?= $activePage === 'job-details' ? 'active' : '' ?>" href="job-details.php">Job Details</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'contact' ? 'active' : '' ?>" href="contact.php">Contact</a>
                </li>
                <li class="nav-item ms-lg-auto">
                    <a class="nav-link" href="#">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-btn btn" href="#">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>