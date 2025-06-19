<?php
session_start();
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/AdminReview.php";

$database = new Database();
$db = $database->getConnection();
$adminReviewObj = new AdminReview($db);

// Kontrola Admina
$adminReviewObj->checkAdminPermission();

// Process delete request first
$adminReviewObj->processDeleteRequest('delete', 'edit-reviews.php');

// Process messages
$messageData = $adminReviewObj->processMessages();
$message = $messageData['message'];
$messageType = $messageData['messageType'];

// Získať všetky recenzie
$reviews = $adminReviewObj->getAllReviewsAdmin();

$activePage = 'admin';
$pageTitle = 'Admin - Edit Reviews';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Admin Panel', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
require_once "functions.php";
?>


<?php include_once "parts/header.php" ?>

<main>
    <section class="job-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <h2 class="mb-4">Review Management</h2>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType == 'success' ? 'success' : ($messageType == 'error' ? 'danger' : 'info'); ?> mb-4">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($reviews)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Rating</th>
                                    <th>Review Text</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($reviews as $review): ?>
                                    <tr>
                                        <td><?php echo $review['idrating']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></strong>
                                            <?php if ($review['is_admin']): ?>
                                                <br><span class="badge bg-warning">Admin</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2"><?php echo $review['stars']; ?>/5</span>
                                                <div class="reviews-icons">
                                                    <?php echo generateStars($review['stars']); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($review['rating_text'])): ?>
                                                <span title="<?php echo htmlspecialchars($review['rating_text']); ?>">
                                                    <?php echo htmlspecialchars(truncateText($review['rating_text'], 60)); ?>
                                                </span>
                                            <?php else: ?>
                                                <em class="text-muted">No review text</em>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($review['created_at'])); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="?delete=<?php echo $review['idrating']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to delete this review?')">
                                                    <i class="bi-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi-info-circle me-2"></i>
                            No reviews found.
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