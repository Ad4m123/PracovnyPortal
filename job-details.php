<?php
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/JobDetail.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: job-listings.php");
    exit;
}

$jobId = (int)$_GET['id'];

$database = new Database();
$db = $database->getConnection();

$jobDetailObj = new JobDetail($db);

$job = $jobDetailObj->getJobById($jobId);

if (!$job) {
    header("Location: job-listings.php");
    exit;
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
                            <a href="#" class="custom-btn btn mt-2">Apply now</a>
                            <a href="#" class="custom-btn custom-border-btn btn mt-2 ms-lg-4 ms-3">Save this job</a>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mt-5 mt-lg-0">
                    <div class="job-thumb job-thumb-detail-box bg-white shadow-lg">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0"><?php echo htmlspecialchars($job['company_name']); ?></h5>
                            <a href="#" class="bi-bookmark ms-auto me-2"></a>
                            <a href="#" class="bi-heart"></a>
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

    <section class="cta-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-10">
                    <h2 class="text-white mb-2">Interested in this job?</h2>
                    <p class="text-white">Apply now to connect with <?php echo htmlspecialchars($job['company_name']); ?> for this position.</p>
                </div>

                <div class="col-lg-4 col-12 ms-auto">
                    <div class="custom-border-btn-wrap d-flex align-items-center mt-lg-4 mt-2">
                        <a href="#" class="custom-btn custom-border-btn btn me-4">Apply now</a>
                        <a href="job-listings.php" class="custom-link">Back to listings</a>
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