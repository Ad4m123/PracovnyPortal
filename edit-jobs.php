<?php
session_start();
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/AdminJob.php";

$database = new Database();
$db = $database->getConnection();
$adminJobObj = new AdminJob($db);

// Kontrola admin oprávnení
$adminJobObj->checkAdminPermission();

// Spracovanie správ
$messageData = $adminJobObj->processMessages();
$message = $messageData['message'];
$messageType = $messageData['messageType'];

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
                        <div class="alert alert-<?php echo $messageType == 'success' ? 'success' : ($messageType == 'error' ? 'danger' : 'info'); ?> mb-4">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <a href="admin/create.php" class="btn btn-success">
                            <i class="bi-plus-circle me-2"></i>Add New Job
                        </a>
                    </div>
                    <?php if (!empty($jobs)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
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
                                <?php foreach ($jobs as $job): ?>
                                    <tr>
                                        <td><?php echo $job['idjob']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($job['title']); ?></strong>
                                            <br><small><?php echo htmlspecialchars($job['level']); ?> • <?php echo htmlspecialchars($job['job_type']); ?></small>
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
                                                <a href="job-details.php?id=<?php echo $job['idjob']; ?>"
                                                   class="btn btn-outline-info btn-sm" target="_blank">
                                                    <i class="bi-eye"></i>
                                                </a>

                                                <a href="admin/edit.php?id=<?php echo $job['idjob']; ?>"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi-pencil"></i>
                                                </a>

                                                <?php if ($job['is_active']): ?>
                                                    <a href="admin/toggle-status.php?id=<?php echo $job['idjob']; ?>&action=deactivate"
                                                       class="btn btn-outline-warning btn-sm">
                                                        <i class="bi-pause-circle"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="admin/toggle-status.php?id=<?php echo $job['idjob']; ?>&action=activate"
                                                       class="btn btn-outline-success btn-sm">
                                                        <i class="bi-play-circle"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="admin/delete.php?id=<?php echo $job['idjob']; ?>"
                                                   class="btn btn-outline-danger btn-sm">
                                                    <i class="bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Jobs pagination">
                                <ul class="pagination justify-content-center mt-4">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi-info-circle me-2"></i>
                            No jobs found. <a href="admin/create.php">Create the first job posting</a>.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "parts/footer.php" ?>
</body>
</html>