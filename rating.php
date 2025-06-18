<?php
session_start();
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/Rating.php";
require_once "classes/RatingValidator.php";
require_once "classes/RatingHandler.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$ratingObj = new Rating($db);

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $stars = isset($_POST['stars']) ? (int)$_POST['stars'] : 0;
    $ratingText = isset($_POST['rating_text']) ? trim($_POST['rating_text']) : '';

    $ratingHandler = new RatingHandler($ratingObj);

    $result = $ratingHandler->handleRatingSubmission($userId, $stars, $ratingText);

    $message = $result['message'];
    $messageType = $result['messageType'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/rating.css" rel="stylesheet">
    <script src="js/rating.js"></script>
</head>

<body id="top">

<?php
$activePage = 'rating';
$pageTitle = 'Rating';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Rating', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<?php include_once "parts/header.php" ?>

<main>
    <section class="job-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <h2 class="mb-4">Rate Our Service</h2>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?> mb-4">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <div class="custom-form bg-white shadow-lg rounded p-4">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label for="stars" class="form-label">Rating *</label>
                                    <div class="rating-stars">
                                        <input type="radio" name="stars" value="1" id="star1" required>
                                        <label for="star1" class="star">★</label>

                                        <input type="radio" name="stars" value="2" id="star2">
                                        <label for="star2" class="star">★</label>

                                        <input type="radio" name="stars" value="3" id="star3">
                                        <label for="star3" class="star">★</label>

                                        <input type="radio" name="stars" value="4" id="star4">
                                        <label for="star4" class="star">★</label>

                                        <input type="radio" name="stars" value="5" id="star5">
                                        <label for="star5" class="star">★</label>
                                    </div>
                                    <small class="form-text text-muted">Click on stars to rate (1-5 stars)</small>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="rating_text" class="form-label">Your Review</label>
                                    <textarea class="form-control" id="rating_text" name="rating_text" rows="5"
                                              placeholder="Share your experience with our service..."></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="form-control btn custom-btn">Submit Rating</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "parts/footer.php" ?>

</body>
</html>