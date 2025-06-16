<?php
session_start();
require_once "../db/config.php";
require_once "../classes/AdminJob.php";

// Admin permission check
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

// ID validation
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "Invalid job posting ID";
    $_SESSION['message_type'] = "error";
    header("Location: ../edit-jobs.php");
    exit;
}

$jobId = (int)$_GET['id'];

$database = new Database();
$db = $database->getConnection();
$adminJobObj = new AdminJob($db);

// Check if job exists
$job = $adminJobObj->getJobByIdAdmin($jobId);
if (!$job) {
    $_SESSION['message'] = "Job posting not found";
    $_SESSION['message_type'] = "error";
    header("Location: ../edit-jobs.php");
    exit;
}

// If confirmed, delete the job
if (isset($_GET['confirmed']) && $_GET['confirmed'] == '1') {
    if ($adminJobObj->deleteJob($jobId)) {
        $_SESSION['message'] = "Job posting '" . htmlspecialchars($job['title']) . "' was successfully deleted";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting job posting";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../edit-jobs.php");
    exit;
}

// If not confirmed, show confirmation page
include_once "../parts/head.php";

$activePage = 'admin';
$pageTitle = 'Delete Job Posting';
$breadcrumbs = [
    ['title' => 'Home', 'link' => '../index.php', 'active' => false],
    ['title' => 'Admin Panel', 'link' => '../edit-jobs.php', 'active' => false],
    ['title' => 'Delete Posting', 'link' => '', 'active' => true]
];
include_once('../parts/nav.php');
require_once "../functions.php";
?>

<body id="top">
<?php include_once "../parts/header.php" ?>

<main>
    <section class="job-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-12">
                    <div class="bg-white shadow-lg rounded p-4">
                        <div class="text-center mb-4">
                            <i class="bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                            <h3 class="mt-3">Delete Job Posting</h3>
                        </div>

                        <div class="alert alert-warning">
                            <h5 class="alert-heading">Warning!</h5>
                            <p class="mb-0">
                                Are you sure you want to delete this job posting?
                                <strong>This action is irreversible!</strong>
                            </p>
                        </div>

                        <!-- Job Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Job Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>ID:</strong> <?php echo $job['idjob']; ?></p>
                                <p><strong>Title:</strong> <?php echo htmlspecialchars($job['title']); ?></p>
                                <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($job['category_name']); ?></p>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?></p>
                                <p><strong>Status:</strong>
                                    <?php if ($job['is_active']): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-0"><strong>Created:</strong> <?php echo date('d.m.Y H:i', strtotime($job['created_at'])); ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="../edit-jobs.php" class="btn btn-secondary">
                                <i class="bi-arrow-left me-2"></i>Cancel
                            </a>
                            <a href="?id=<?php echo $jobId; ?>&confirmed=1" class="btn btn-danger">
                                <i class="bi-trash me-2"></i>Confirm Deletion
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "../parts/footer.php" ?>
</body>
</html>
