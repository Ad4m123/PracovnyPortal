<?php
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/Job.php";

// Create database connection
$database = new Database();
$db = $database->getConnection();

// Initialize Job class
$jobObj = new Job($db);

// Set default values for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 9; // Display 9 jobs per page
$offset = ($page - 1) * $itemsPerPage;

// Handle search parameters
$title = isset($_GET['job-title']) ? $_GET['job-title'] : null;
$location = isset($_GET['job-location']) ? $_GET['job-location'] : null;
$jobType = isset($_GET['job-remote']) ? $_GET['job-remote'] : null;
$level = isset($_GET['job-level']) ? $_GET['job-level'] : null;

// Get jobs based on search parameters or get all jobs
if ($title || $location || $jobType || $level) {
    $jobs = $jobObj->searchJobs($title, $location, $jobType, $level, $itemsPerPage, $offset);
    $totalJobs = count($jobObj->searchJobs($title, $location, $jobType, $level));
} else {
    $jobs = $jobObj->getAllJobs($itemsPerPage, $offset);
    $totalJobs = $jobObj->countAllJobs();
}

// Calculate total pages
$totalPages = ceil($totalJobs / $itemsPerPage);
?>

<body id="top">
<?php
$activePage = 'jobs';
$pageTitle = 'Job Listings';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Job Listings', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<main>
    <?php include_once('parts/header.php'); ?>


    <section class="section-padding pb-0 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12">
                    <form class="custom-form hero-form" action="job-listings.php" method="get" role="form">
                        <h3 class="text-white mb-3">Search your dream job</h3>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi-person custom-icon"></i></span>

                                    <input type="text" name="job-title" id="job-title" class="form-control" placeholder="Job Title" value="<?php echo htmlspecialchars($title ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi-geo-alt custom-icon"></i></span>

                                    <input type="text" name="job-location" id="job-location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($location ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi-cash custom-icon"></i></span>

                                    <select class="form-select form-control" name="job-salary" id="job-salary">
                                        <option value="">Salary Range</option>
                                        <option value="1">$300k - $500k</option>
                                        <option value="2">$10000k - $45000k</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi-laptop custom-icon"></i></span>

                                    <select class="form-select form-control" name="job-level" id="job-level">
                                        <option value="">Level</option>
                                        <option value="Internship" <?php echo $level == 'Internship' ? 'selected' : ''; ?>>Internship</option>
                                        <option value="Junior" <?php echo $level == 'Junior' ? 'selected' : ''; ?>>Junior</option>
                                        <option value="Mid Level" <?php echo $level == 'Mid Level' ? 'selected' : ''; ?>>Mid Level</option>
                                        <option value="Senior" <?php echo $level == 'Senior' ? 'selected' : ''; ?>>Senior</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi-laptop custom-icon"></i></span>

                                    <select class="form-select form-control" name="job-remote" id="job-remote">
                                        <option value="">Job Type</option>
                                        <option value="Full Time" <?php echo $jobType == 'Full Time' ? 'selected' : ''; ?>>Full Time</option>
                                        <option value="Part Time" <?php echo $jobType == 'Part Time' ? 'selected' : ''; ?>>Part Time</option>
                                        <option value="Contract" <?php echo $jobType == 'Contract' ? 'selected' : ''; ?>>Contract</option>
                                        <option value="Freelance" <?php echo $jobType == 'Freelance' ? 'selected' : ''; ?>>Freelance</option>
                                        <option value="Remote" <?php echo $jobType == 'Remote' ? 'selected' : ''; ?>>Remote</option>
                                        <option value="Internship" <?php echo $jobType == 'Internship' ? 'selected' : ''; ?>>Internship</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <button type="submit" class="form-control">
                                    Search job
                                </button>
                            </div>

                            <div class="col-12">
                                <div class="d-flex flex-wrap align-items-center mt-4 mt-lg-0">
                                    <span class="text-white mb-lg-0 mb-md-0 me-2">Popular keywords:</span>

                                    <div>
                                        <a href="job-listings.php?job-title=Web+design" class="badge">Web design</a>
                                        <a href="job-listings.php?job-title=Marketing" class="badge">Marketing</a>
                                        <a href="job-listings.php?job-title=Customer+support" class="badge">Customer support</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 col-12">
                    <img src="images/4557388.png" class="hero-image img-fluid" alt="">
                </div>

            </div>
        </div>
    </section>


    <section class="job-section section-padding">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-12 mb-lg-4">
                    <h3>Results of <?php echo ($page - 1) * $itemsPerPage + 1; ?>-<?php echo min($page * $itemsPerPage, $totalJobs); ?> of <?php echo $totalJobs; ?> jobs</h3>
                </div>

                <div class="col-lg-4 col-12 d-flex align-items-center ms-auto mb-5 mb-lg-4">
                    <p class="mb-0 ms-lg-auto">Sort by:</p>

                    <div class="dropdown dropdown-sorting ms-3 me-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSortingButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Newest Jobs
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownSortingButton">
                            <li><a class="dropdown-item" href="#">Latest Jobs</a></li>
                            <li><a class="dropdown-item" href="#">Highest Salary Jobs</a></li>
                            <li><a class="dropdown-item" href="#">Internship Jobs</a></li>
                        </ul>
                    </div>

                    <div class="d-flex">
                        <a href="#" class="sorting-icon active bi-list me-2"></a>
                        <a href="#" class="sorting-icon bi-grid"></a>
                    </div>
                </div>

                <?php foreach ($jobs as $job): ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="job-thumb job-thumb-box">
                            <div class="job-body">
                                <h4 class="job-title">
                                    <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="job-title-link"><?php echo htmlspecialchars($job['title']); ?></a>
                                </h4>

                                <div class="d-flex align-items-center mt-2">
                                    <p class="mb-0"><?php echo htmlspecialchars($job['company_name']); ?></p>
                                    <a href="#" class="bi-bookmark ms-auto me-2"></a>
                                    <a href="#" class="bi-heart"></a>
                                </div>

                                <div class="d-flex flex-wrap mt-2">
                                    <p class="mb-0 me-3">
                                        <a href="job-listings.php?job-level=<?php echo urlencode($job['level']); ?>" class="badge badge-level"><?php echo htmlspecialchars($job['level']); ?></a>
                                    </p>

                                    <p class="mb-0">
                                        <a href="job-listings.php?job-remote=<?php echo urlencode($job['job_type']); ?>" class="badge"><?php echo htmlspecialchars($job['job_type']); ?></a>
                                    </p>
                                </div>

                                <div class="d-flex align-items-center mt-2">
                                    <p class="job-location">
                                        <i class="custom-icon bi-geo-alt me-1"></i>
                                        <?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?>
                                    </p>

                                    <p class="job-date ms-3">
                                        <i class="custom-icon bi-clock me-1"></i>
                                        <?php echo formatTimeAgo($job['created_at']); ?>
                                    </p>
                                </div>

                                <div class="d-flex align-items-center border-top pt-3 mt-3">
                                    <p class="job-price mb-0">
                                        <i class="custom-icon bi-cash me-1"></i>
                                        $<?php echo number_format($job['salary'], 0); ?>
                                    </p>

                                    <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="custom-btn btn ms-auto">Apply now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($jobs)): ?>
                    <div class="col-12 text-center mt-4">
                        <p>No jobs found matching your criteria. Try different search parameters.</p>
                    </div>
                <?php endif; ?>

                <div class="col-lg-12 col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-5">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $title ? '&job-title=' . urlencode($title) : ''; ?><?php echo $location ? '&job-location=' . urlencode($location) : ''; ?><?php echo $jobType ? '&job-remote=' . urlencode($jobType) : ''; ?><?php echo $level ? '&job-level=' . urlencode($level) : ''; ?>" aria-label="Previous">
                                        <span aria-hidden="true">Prev</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php
                            // Show up to 5 page numbers
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $startPage + 4);

                            if ($endPage - $startPage < 4 && $startPage > 1) {
                                $startPage = max(1, $endPage - 4);
                            }

                            for ($i = $startPage; $i <= $endPage; $i++):
                                ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>" aria-current="<?php echo $i == $page ? 'page' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $title ? '&job-title=' . urlencode($title) : ''; ?><?php echo $location ? '&job-location=' . urlencode($location) : ''; ?><?php echo $jobType ? '&job-remote=' . urlencode($jobType) : ''; ?><?php echo $level ? '&job-level=' . urlencode($level) : ''; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $title ? '&job-title=' . urlencode($title) : ''; ?><?php echo $location ? '&job-location=' . urlencode($location) : ''; ?><?php echo $jobType ? '&job-remote=' . urlencode($jobType) : ''; ?><?php echo $level ? '&job-level=' . urlencode($level) : ''; ?>" aria-label="Next">
                                        <span aria-hidden="true">Next</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </section>


    <section class="cta-section">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-10">
                    <h2 class="text-white mb-2">Over <?php echo $totalJobs; ?> opening jobs</h2>

                    <p class="text-white">Gotto Job is a free HTML CSS template for job hunting related websites. This layout is based on the famous Bootstrap 5 CSS framework. Thank you for visiting Tooplate website.</p>
                </div>

                <div class="col-lg-4 col-12 ms-auto">
                    <div class="custom-border-btn-wrap d-flex align-items-center mt-lg-4 mt-2">
                        <a href="register.php" class="custom-btn custom-border-btn btn me-4">Create an account</a>

                        <a href="#" class="custom-link">Post a job</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
$file_path = "parts/footer.php";
if(!include_once($file_path)) {
    echo "Failed to include $file_path";
}
?>

</body>
</html>