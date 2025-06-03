<?php
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/Job.php";
require_once "classes/Category.php";

// Create database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes
$jobObj = new Job($db);
$categoryObj = new Category($db);

// Set default values for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 9;
$offset = ($page - 1) * $itemsPerPage;

// Handle search parameters
$title = isset($_GET['job-title']) ? $_GET['job-title'] : null;
$location = isset($_GET['job-location']) ? $_GET['job-location'] : null;
$jobType = isset($_GET['job-remote']) ? $_GET['job-remote'] : null;
$level = isset($_GET['job-level']) ? $_GET['job-level'] : null;
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;

// Get category name for display
$currentCategory = null;
if ($categoryId) {
    $currentCategory = $categoryObj->getCategoryById($categoryId);
}

// Get jobs based on search parameters
if ($categoryId) {
    $jobs = $jobObj->getJobsByCategory($categoryId, $itemsPerPage, $offset);
    $totalJobs = $jobObj->countJobsByCategory($categoryId);
} elseif ($title || $location || $jobType || $level) {
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
$pageTitle = $currentCategory ? $currentCategory['name'] . ' Jobs' : 'Job Listings';
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
                    <?php if ($currentCategory): ?>
                        <div class="alert alert-info text-center">
                            <h5>Showing jobs in category: <strong><?php echo htmlspecialchars($currentCategory['name']); ?></strong></h5>
                            <a href="job-listings.php" class="btn btn-sm btn-outline-primary">Show All Jobs</a>
                        </div>
                    <?php endif; ?>

                    <form class="custom-form hero-form" action="job-listings.php" method="get" role="form">
                        <h3 class="text-white mb-3">Search your dream job</h3>

                        <?php if ($categoryId): ?>
                            <input type="hidden" name="category" value="<?php echo $categoryId; ?>">
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-person custom-icon"></i></span>
                                    <input type="text" name="job-title" class="form-control" placeholder="Job Title" value="<?php echo htmlspecialchars($title ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-geo-alt custom-icon"></i></span>
                                    <input type="text" name="job-location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($location ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-laptop custom-icon"></i></span>
                                    <select class="form-select form-control" name="job-level">
                                        <option value="">Level</option>
                                        <option value="Internship" <?php echo $level == 'Internship' ? 'selected' : ''; ?>>Internship</option>
                                        <option value="Junior" <?php echo $level == 'Junior' ? 'selected' : ''; ?>>Junior</option>
                                        <option value="Mid Level" <?php echo $level == 'Mid Level' ? 'selected' : ''; ?>>Mid Level</option>
                                        <option value="Senior" <?php echo $level == 'Senior' ? 'selected' : ''; ?>>Senior</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-laptop custom-icon"></i></span>
                                    <select class="form-select form-control" name="job-remote">
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
                                <button type="submit" class="form-control">Search job</button>
                            </div>
                        </div>
                    </form>
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
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Newest Jobs
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Latest Jobs</a></li>
                            <li><a class="dropdown-item" href="#">Highest Salary Jobs</a></li>
                        </ul>
                    </div>
                </div>

                <?php foreach ($jobs as $job): ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="job-thumb job-thumb-box">
                            <div class="job-body">
                                <h4 class="job-title">
                                    <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="job-title-link"><?php echo htmlspecialchars($job['title']); ?></a>
                                </h4>

                                <div class="d-flex flex-wrap">
                                    <p class="mb-0">
                                        <a href="job-listings.php?job-level=<?php echo urlencode($job['level']); ?>" class="badge badge-level"><?php echo htmlspecialchars($job['level']); ?></a>
                                    </p>
                                    <p class="mb-0">
                                        <a href="job-listings.php?job-remote=<?php echo urlencode($job['job_type']); ?>" class="badge"><?php echo htmlspecialchars($job['job_type']); ?></a>
                                    </p>
                                </div>

                                <div class="d-flex align-items-center">
                                    <p class="job-location">
                                        <i class="custom-icon bi-geo-alt me-1"></i>
                                        <?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?>
                                    </p>

                                    <p class="job-date">
                                        <i class="custom-icon bi-clock me-1"></i>
                                        <?php echo formatTimeAgo($job['created_at']); ?>
                                    </p>
                                </div>

                                <div class="d-flex align-items-center border-top pt-3">
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
                        <p>No jobs found matching your criteria.</p>
                    </div>
                <?php endif; ?>

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