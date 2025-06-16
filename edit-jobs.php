<?php
session_start();
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/AdminJob.php";

// Kontrola admin oprávnení
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$adminJobObj = new AdminJob($db);

// Spracovanie správ
$message = '';
$messageType = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['message_type'];
    unset($_SESSION['message'], $_SESSION['message_type']);
}

// Paginácia
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 10;
$offset = ($page - 1) * $itemsPerPage;

// Získať pracovné ponuky
$jobs = $adminJobObj->getAllJobsAdmin($itemsPerPage, $offset);
$totalJobs = $adminJobObj->countAllJobsAdmin();
$totalPages = ceil($totalJobs / $itemsPerPage);

$activePage = 'admin';
$pageTitle = 'Admin - Edit Jobs';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Admin Panel', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<body id="top">
<?php include_once "parts/header.php" ?>

<main>
    <section class="job-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <h2 class="mb-4">Job Management</h2>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType == 'success' ? 'success' : ($messageType == 'error' ? 'danger' : 'info'); ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tlačidlo na pridanie novej ponuky -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0">Total jobs: <strong><?php echo $totalJobs; ?></strong></p>
                        <a href="admin/create.php" class="btn btn-primary">
                            <i class="bi-plus-circle me-2"></i>Add New Job
                        </a>
                    </div>

                    <!-- Tabuľka s pracovnými ponukami -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($jobs)): ?>
                                <?php foreach ($jobs as $job): ?>
                                    <tr>
                                        <td><?php echo $job['idjob']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($job['title']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($job['level'] . ' • ' . $job['job_type']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                                        <td><?php echo htmlspecialchars($job['category_name']); ?></td>
                                        <td><?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?></td>
                                        <td>$<?php echo number_format($job['salary'], 0); ?></td>
                                        <td>
                                            <?php if ($job['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d.m.Y', strtotime($job['created_at'])); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- View -->
                                                <a href="job-details.php?id=<?php echo $job['idjob']; ?>"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="View">
                                                    <i class="bi-eye"></i>
                                                </a>

                                                <!-- Edit -->
                                                <a href="admin/edit.php?id=<?php echo $job['idjob']; ?>"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Edit">
                                                    <i class="bi-pencil"></i>
                                                </a>

                                                <!-- Activate/Deactivate -->
                                                <?php if ($job['is_active']): ?>
                                                    <a href="admin/toggle-status.php?id=<?php echo $job['idjob']; ?>&action=deactivate"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Deactivate"
                                                       onclick="return confirm('Do you really want to deactivate this job?')">
                                                        <i class="bi-pause-circle"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="admin/toggle-status.php?id=<?php echo $job['idjob']; ?>&action=activate"
                                                       class="btn btn-sm btn-outline-success"
                                                       title="Activate">
                                                        <i class="bi-play-circle"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <!-- Delete -->
                                                <a href="admin/delete.php?id=<?php echo $job['idjob']; ?>"
                                                   class="btn btn-sm btn-outline-danger"
                                                   title="Delete"
                                                   onclick="return confirm('Do you really want to delete this job? This action is irreversible!')">
                                                    <i class="bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <p class="mb-0">No job listings found.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginácia -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Stránkovanie">
                            <ul class="pagination justify-content-center mt-4">
                                <!-- Predchádzajúca stránka -->
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                    </li>
                                <?php endif; ?>

                                <!-- Čísla stránok -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Ďalšia stránka -->
                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "parts/footer.php" ?>
</body>
</html>