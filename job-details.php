<?php
session_start();
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/Job.php";
require_once "classes/SavedJob.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: job-listings.php");
    exit;
}

$jobId = (int)$_GET['id'];

$database = new Database();
$db = $database->getConnection();

$jobObj = new Job($db);
$savedJobObj = new SavedJob($db);

$job = $jobObj->getJobById($jobId);

if (!$job) {
    header("Location: job-listings.php");
    exit;
}

// Check if job is saved (for logged in users)
$isJobSaved = false;
if (isset($_SESSION['user_id'])) {
    $isJobSaved = $savedJobObj->isJobSaved($_SESSION['user_id'], $jobId);
}

$activePage = 'job-details';
$pageTitle = $job['title'];
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Job Listings', 'link' => 'job-listings.php', 'active' => false],
    ['title' => $job['title'], 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<body id="top">
<?php include_once "parts/header.php" ?>

<main>
    <section class="job-section section-padding pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <h2 class="job-title mb-0"><?php echo htmlspecialchars($job['title']); ?></h2>

                    <div class="job-thumb job-thumb-detail">
                        <div class="d-flex flex-wrap align-items-center border-bottom pt-lg-3 pt-2 pb-3 mb-4">
                            <p class="job-location mb-0">
                                <i class="custom-icon bi-geo-alt me-1"></i>
                                <?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?>
                            </p>

                            <p class="job-date mb-0">
                                <i class="custom-icon bi-clock me-1"></i>
                                <?php echo formatTimeAgo($job['created_at']); ?>
                            </p>

                            <div class="d-flex align-items-center mb-0">
                                <p class="job-price mb-0">
                                    <i class="custom-icon bi-cash me-1"></i>
                                    $<?php echo number_format($job['salary'], 0); ?>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <p class="mb-0">
                                <a href="job-listings.php?job-level=<?php echo urlencode($job['level']); ?>" class="badge badge-level"><?php echo htmlspecialchars($job['level']); ?></a>
                            </p>

                            <p class="mb-0">
                                <a href="job-listings.php?job-remote=<?php echo urlencode($job['job_type']); ?>" class="badge"><?php echo htmlspecialchars($job['job_type']); ?></a>
                            </p>
                        </div>

                        <h4 class="mt-4 mb-2">Job Description</h4>
                        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

                        <?php if(!empty($job['requirements'])): ?>
                            <h5 class="mt-4 mb-3">Requirements</h5>
                            <div><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></div>
                        <?php endif; ?>

                        <?php if(!empty($job['benefits'])): ?>
                            <h5 class="mt-4 mb-3">Benefits</h5>
                            <div><?php echo nl2br(htmlspecialchars($job['benefits'])); ?></div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-center flex-wrap mt-5 border-top pt-4 mb-4">
                            <a href="mailto:<?php echo htmlspecialchars($job['company_email']); ?>?subject=Application for <?php echo urlencode($job['title']); ?>" class="custom-btn btn mt-2">Apply now</a>


                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if ($isJobSaved): ?>
                                    <a href="liked-jobs.php" class="custom-btn custom-border-btn btn mt-2 ms-lg-4 ms-3">
                                        <i class="bi-heart-fill me-1"></i>Already Saved
                                    </a>
                                <?php else: ?>
                                    <a href="db/save-job.php?job_id=<?php echo $jobId; ?>" class="custom-btn custom-border-btn btn mt-2 ms-lg-4 ms-3">
                                        <i class="bi-heart me-1"></i>Save this job
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="custom-btn custom-border-btn btn mt-2 ms-lg-4 ms-3">
                                    <i class="bi-heart me-1"></i>Save this job
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mt-5 mt-lg-0">
                    <div class="job-thumb job-thumb-detail-box bg-white shadow-lg">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0"><?php echo htmlspecialchars($job['company_name']); ?></h5>

                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if ($isJobSaved): ?>
                                    <a href="liked-jobs.php" class="bi-heart-fill text-danger"></a>
                                <?php else: ?>

                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="bi-heart"></a>
                            <?php endif; ?>
                        </div>

                        <h6 class="mt-3 mb-2">About the Company</h6>
                        <p><?php echo !empty($job['company_about']) ?
                                htmlspecialchars($job['company_about']) :
                                'No company description available.'; ?></p>

                        <h6 class="mt-4 mb-3">Contact Information</h6>

                        <?php if(!empty($job['website'])): ?>
                            <p class="mb-2">
                                <i class="custom-icon bi-globe me-1"></i>
                                <a href="<?php echo htmlspecialchars($job['website']); ?>" class="site-footer-link" target="_blank">
                                    <?php echo htmlspecialchars($job['website']); ?>
                                </a>
                            </p>
                        <?php endif; ?>

                        <?php if(!empty($job['company_phone'])): ?>
                            <p class="mb-2">
                                <i class="custom-icon bi-telephone me-1"></i>
                                <a href="tel:<?php echo htmlspecialchars($job['company_phone']); ?>" class="site-footer-link">
                                    <?php echo htmlspecialchars($job['company_phone']); ?>
                                </a>
                            </p>
                        <?php endif; ?>

                        <?php if(!empty($job['company_email'])): ?>
                            <p>
                                <i class="custom-icon bi-envelope me-1"></i>
                                <a href="mailto:<?php echo htmlspecialchars($job['company_email']); ?>" class="site-footer-link">
                                    <?php echo htmlspecialchars($job['company_email']); ?>
                                </a>
                            </p>
                        <?php endif; ?>
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