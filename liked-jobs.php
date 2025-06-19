<?php
session_start();
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/SavedJob.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

$savedJobObj = new SavedJob($db);
$userId = $_SESSION['user_id'];

// Get user's saved jobs
$savedJobs = $savedJobObj->getUserSavedJobs($userId);
?>

<?php
$activePage = 'liked-jobs';
$pageTitle = 'Liked Jobs';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Liked Jobs', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<?php include_once "parts/header.php" ?>

<main>

    <section class="job-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mb-4">
                    <h3><?php echo count($savedJobs); ?> Liked Jobs</h3>
                </div>

                <?php if (!empty($savedJobs)): ?>
                    <?php foreach ($savedJobs as $job): ?>
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

                                        <div class="ms-auto d-flex">
                                            <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="custom-btn btn me-2">View</a>
                                            <a href="db/remove-saved-job.php?job_id=<?php echo $job['idjob']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove this job from liked jobs?')">>
                                                <i class="bi-heart-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center">
                            <div class="job-thumb d-flex justify-content-center">
                                <div class="job-body text-center">
                                    <h4 class="job-title mb-4">No Liked Jobs Yet</h4>
                                    <p class="mb-4">Start exploring and save jobs you're interested in!</p>
                                    <a href="job-listings.php" class="custom-btn btn">Browse Jobs</a>
                                </div>
                            </div>
                        </div>
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