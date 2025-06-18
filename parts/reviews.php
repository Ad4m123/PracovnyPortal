<?php
// Include necessary files if not already included
if (!class_exists('Database')) {
    require_once "db/config.php";
}
if (!class_exists('Rating')) {
    require_once "classes/Rating.php";
}

// Include functions file
require_once "functions.php";

// Get database connection
$database = new Database();
$db = $database->getConnection();
$ratingObj = new Rating($db);

// Get latest 6 ratings for display
$reviews = $ratingObj->getLatestRatings(6);
?>

<section class="reviews-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <h2 class="text-center mb-5">Happy customers</h2>

                <?php if (!empty($reviews)): ?>
                    <div class="owl-carousel owl-theme reviews-carousel">
                        <?php foreach ($reviews as $index => $review): ?>
                            <div class="reviews-thumb">
                                <div class="reviews-info d-flex align-items-center">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap w-100">
                                        <p class="mb-0">
                                            <strong><?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></strong>
                                            <small>Customer</small>
                                        </p>

                                        <div class="reviews-icons">
                                            <?php echo generateStars($review['stars']); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="reviews-body">
                                    <img src="images/left-quote.png" class="quote-icon img-fluid" alt="">

                                    <h4 class="reviews-title">
                                        <?php echo htmlspecialchars(truncateText($review['rating_text'], 120)); ?>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- No reviews message -->
                    <div class="text-center">
                        <p class="lead">No reviews yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>