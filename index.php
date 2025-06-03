<?php
include_once "parts/head.php";
require_once "db/config.php";
require_once "classes/Job.php";
require_once "classes/Category.php";
require_once "functions.php";


$database = new Database();
$db = $database->getConnection();

$jobObj = new Job($db);
$jobs = $jobObj->getAllJobs(6);

$categoryObj = new Category($db);
$categories = $categoryObj->getAllCategories();
?>

<body id="top">

<?php
$activePage = 'home';
include_once('parts/nav.php');
?>

<main>

    <section class="hero-section d-flex justify-content-center align-items-center">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <div class="hero-section-text mt-5">
                        <h6 class="text-white">Are you looking for your dream job?</h6>

                        <h1 class="hero-title text-white mt-4 mb-4">Online Platform. <br> Best Job portal</h1>

                        <a href="#categories-section" class="custom-btn custom-border-btn btn">Browse Categories</a>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <form class="custom-form hero-form" action="job-listings.php" method="get" role="form">
                        <h3 class="text-white mb-3">Search your dream job</h3>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi-person custom-icon"></i></span>

                                    <input type="text" name="job-title" id="job-title" class="form-control" placeholder="Job Title" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2"><i class="bi-geo-alt custom-icon"></i></span>

                                    <input type="text" name="job-location" id="job-location" class="form-control" placeholder="Location" required>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <button type="submit" class="form-control">
                                    Find a job
                                </button>
                            </div>

                            <div class="col-12">
                                <div class="d-flex flex-wrap align-items-center mt-4 mt-lg-0">
                                    <span class="text-white mb-lg-0 mb-md-0 me-2">Popular keywords:</span>

                                    <div>
                                        <a href="job-listings.php?job-title=Web+design" class="badge">Web design</a>

                                        <a href="job-listings.php?job-title=Marketing" class="badge">Marketing</a>

                                        <a href="job-listings.php?job-title=Customer+support" class="badge">Customer support</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>


    <section class="categories-section section-padding" id="categories-section">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-12 col-12 text-center">
                    <h2 class="mb-5">Browse by <span>Categories</span></h2>
                </div>

                <?php foreach ($categories as $category): ?>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="categories-block">
                            <a href="job-listings.php?category=<?php echo $category['idcategory']; ?>" class="d-flex flex-column justify-content-center align-items-center h-100">
                                <i class="categories-icon <?php echo $categoryObj->getCategoryIcon($category['name']); ?>"></i>

                                <small class="categories-block-title"><?php echo htmlspecialchars($category['name']); ?></small>

                                <div class="categories-block-number d-flex flex-column justify-content-center align-items-center">
                                    <span class="categories-block-number-text"><?php echo $category['job_count']; ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>


    <section class="about-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-12">
                    <div class="about-image-wrap custom-border-radius-start">
                        <img src="images/professional-asian-businesswoman-gray-blazer.jpg" class="about-image custom-border-radius-start img-fluid" alt="">

                        <div class="about-info">
                            <h4 class="text-white mb-0 me-2">Julia Ward</h4>

                            <p class="text-white mb-0">Investor</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="custom-text-block">
                        <h2 class="text-white mb-2">Introduction Gotto</h2>

                        <p class="text-white">Gotto Job is a free website template for job portals. This layout is based on Bootstrap 5 CSS framework. Thank you for visiting <a href="https://www.tooplate.com" target="_parent">Tooplate website</a>. Images are from <a href="https://www.freepik.com/" target="_blank">FreePik</a> website.</p>

                        <div class="custom-border-btn-wrap d-flex align-items-center mt-5">
                            <a href="about.php" class="custom-btn custom-border-btn btn me-4">Get to know us</a>

                            <a href="#job-section" class="custom-link smoothscroll">Explore Jobs</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="instagram-block">
                        <img src="images/horizontal-shot-happy-mixed-race-females.jpg" class="about-image custom-border-radius-end img-fluid" alt="">

                        <div class="instagram-block-text">
                            <a href="https://instagram.com/" class="custom-btn btn">
                                <i class="bi-instagram"></i>
                                @Gotto
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="job-section job-featured-section section-padding" id="job-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 text-center mx-auto mb-4">
                    <h2>Featured Jobs</h2>

                    <p><strong>Over <?php echo count($jobs); ?> latest jobs</strong> Feel free to browse through our newest job opportunities.</p>
                </div>

                <div class="col-lg-12 col-12">
                    <?php if (!empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                            <div class="job-thumb d-flex">
                                <div class="job-body d-flex flex-wrap flex-auto align-items-center ms-4">
                                    <div class="mb-3">
                                        <h4 class="job-title mb-lg-0">
                                            <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="job-title-link"><?php echo htmlspecialchars($job['title']); ?></a>
                                        </h4>

                                        <div class="d-flex flex-wrap align-items-center">
                                            <p class="job-location mb-0">
                                                <i class="custom-icon bi-geo-alt me-1"></i>
                                                <?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?>
                                            </p>

                                            <p class="job-date mb-0">
                                                <i class="custom-icon bi-clock me-1"></i>
                                                <?php echo formatTimeAgo($job['created_at']); ?>
                                            </p>

                                            <p class="job-price mb-0">
                                                <i class="custom-icon bi-cash me-1"></i>
                                                $<?php echo number_format($job['salary'], 0); ?>
                                            </p>

                                            <div class="d-flex">
                                                <p class="mb-0">
                                                    <a href="job-listings.php?job-level=<?php echo urlencode($job['level']); ?>" class="badge badge-level"><?php echo htmlspecialchars($job['level']); ?></a>
                                                </p>

                                                <p class="mb-0">
                                                    <a href="job-listings.php?job-remote=<?php echo urlencode($job['job_type']); ?>" class="badge"><?php echo htmlspecialchars($job['job_type']); ?></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="job-section-btn-wrap">
                                        <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="custom-btn btn">Apply now</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center">
                            <p>No jobs available at the moment. Please check back later.</p>
                        </div>
                    <?php endif; ?>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-5">
                            <li class="page-item">
                                <div class="job-section-btn-wrap">
                                    <a href="job-listings.php" class="custom-btn btn">View all jobs</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12">
                    <div class="custom-text-block custom-border-radius-start">
                        <h2 class="text-white mb-3">Gotto helps you an easier way to get new job</h2>

                        <p class="text-white">You are not allowed to redistribute the template ZIP file on any other template collection website. Please contact us for more info. Thank you.</p>

                        <div class="d-flex mt-4">
                            <div class="counter-thumb">
                                <div class="d-flex">
                                    <span class="counter-number" data-from="1" data-to="12" data-speed="1000"></span>
                                    <span class="counter-number-text">M</span>
                                </div>

                                <span class="counter-text">Daily active users</span>
                            </div>

                            <div class="counter-thumb">
                                <div class="d-flex">
                                    <span class="counter-number" data-from="1" data-to="450" data-speed="1000"></span>
                                    <span class="counter-number-text">k</span>
                                </div>

                                <span class="counter-text">Opening jobs</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="video-thumb">
                        <img src="images/people-working-as-team-company.jpg" class="about-image custom-border-radius-end img-fluid" alt="">

                        <div class="video-info">
                            <a href="https://www.youtube.com/tooplate" class="youtube-icon bi-youtube"></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="job-section recent-jobs-section section-padding">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-12 mb-4">
                    <h2>Recent Jobs</h2>

                    <p><strong>Over <?php echo count($jobs); ?> latest jobs</strong></p>
                </div>

                <div class="clearfix"></div>

                <section class="job-section job-featured-section section-padding" id="job-section">
                    <div class="container">
                        <div class="row">


                            <?php if (!empty($jobs)): ?>
                                <?php foreach ($jobs as $index => $job): ?>
                                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                                        <div class="job-thumb job-thumb-box">
                                            <div class="job-body">
                                                <h4 class="job-title">
                                                    <a href="job-details.php?id=<?php echo $job['idjob']; ?>" class="job-title-link"><?php echo htmlspecialchars($job['title']); ?></a>
                                                </h4>

                                                <div class="d-flex align-items-center mt-2">
                                                    <p class="mb-0"><?php echo htmlspecialchars($job['company_name']); ?></p>
                                                    <a href="#" class="bi-bookmark ms-auto me-2"></a>
                                                    <a href="#" class="bi-heart"></a>
                                                </div>

                                                <div class="d-flex flex-wrap mt-2">
                                                    <p class="mb-0 me-3">
                                                        <a href="job-listings.php?job-level=<?php echo urlencode($job['level']); ?>" class="badge badge-level"><?php echo htmlspecialchars($job['level']); ?></a>
                                                    </p>

                                                    <p class="mb-0">
                                                        <a href="job-listings.php?job-remote=<?php echo urlencode($job['job_type']); ?>" class="badge"><?php echo htmlspecialchars($job['job_type']); ?></a>
                                                    </p>
                                                </div>

                                                <div class="d-flex align-items-center mt-2">
                                                    <p class="job-location">
                                                        <i class="custom-icon bi-geo-alt me-1"></i>
                                                        <?php echo htmlspecialchars($job['city'] . ', ' . $job['country']); ?>
                                                    </p>

                                                    <p class="job-date ms-3">
                                                        <i class="custom-icon bi-clock me-1"></i>
                                                        <?php echo formatTimeAgo($job['created_at']); ?>
                                                    </p>
                                                </div>

                                                <div class="d-flex align-items-center border-top pt-3 mt-3">
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
                            <?php else: ?>
                                <div class="col-12 text-center">
                                    <p>No jobs available at the moment. Please check back later.</p>
                                </div>
                            <?php endif; ?>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center mt-5">
                                    <li class="page-item">
                                        <div class="job-section-btn-wrap">
                                            <a href="job-listings.php" class="custom-btn btn">View all jobs</a>
                                        </div>
                                    </li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </section>


    <section class="reviews-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12">
                    <h2 class="text-center mb-5">Happy customers</h2>

                    <div class="owl-carousel owl-theme reviews-carousel">
                        <div class="reviews-thumb">

                            <div class="reviews-info d-flex align-items-center">
                                <img src="images/avatar/portrait-charming-middle-aged-attractive-woman-with-blonde-hair.jpg" class="avatar-image img-fluid" alt="">

                                <div class="d-flex align-items-center justify-content-between flex-wrap w-100 ms-3">
                                    <p class="mb-0">
                                        <strong>Susan L</strong>
                                        <small>Product Manager</small>
                                    </p>

                                    <div class="reviews-icons">
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="reviews-body">
                                <img src="images/left-quote.png" class="quote-icon img-fluid" alt="">

                                <h4 class="reviews-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h4>
                            </div>
                        </div>

                        <div class="reviews-thumb">
                            <div class="reviews-info d-flex align-items-center">
                                <img src="images/avatar/medium-shot-smiley-senior-man.jpg" class="avatar-image img-fluid" alt="">

                                <div class="d-flex align-items-center justify-content-between flex-wrap w-100 ms-3">
                                    <p class="mb-0">
                                        <strong>Jack</strong>
                                        <small>Technical Lead</small>
                                    </p>

                                    <div class="reviews-icons">
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star"></i>
                                        <i class="bi-star"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="reviews-body">
                                <img src="images/left-quote.png" class="quote-icon img-fluid" alt="">

                                <h4 class="reviews-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h4>
                            </div>
                        </div>

                        <div class="reviews-thumb">

                            <div class="reviews-info d-flex align-items-center">
                                <img src="images/avatar/portrait-beautiful-young-woman.jpg" class="avatar-image img-fluid" alt="">

                                <div class="d-flex align-items-center justify-content-between flex-wrap w-100 ms-3">
                                    <p class="mb-0">
                                        <strong>Haley</strong>
                                        <small>Sales & Marketing</small>
                                    </p>

                                    <div class="reviews-icons">
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="reviews-body">
                                <img src="images/left-quote.png" class="quote-icon img-fluid" alt="">

                                <h4 class="reviews-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h4>
                            </div>
                        </div>

                        <div class="reviews-thumb">
                            <div class="reviews-info d-flex align-items-center">
                                <img src="images/avatar/blond-man-happy-expression.jpg" class="avatar-image img-fluid" alt="">

                                <div class="d-flex align-items-center justify-content-between flex-wrap w-100 ms-3">
                                    <p class="mb-0">
                                        <strong>Jackson</strong>
                                        <small>Dev Ops</small>
                                    </p>

                                    <div class="reviews-icons">
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star"></i>
                                        <i class="bi-star"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="reviews-body">
                                <img src="images/left-quote.png" class="quote-icon img-fluid" alt="">

                                <h4 class="reviews-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h4>
                            </div>
                        </div>

                        <div class="reviews-thumb">
                            <div class="reviews-info d-flex align-items-center">
                                <img src="images/avatar/university-study-abroad-lifestyle-concept.jpg" class="avatar-image img-fluid" alt="">

                                <div class="d-flex align-items-center justify-content-between flex-wrap w-100 ms-3">
                                    <p class="mb-0">
                                        <strong>Kevin</strong>
                                        <small>Internship</small>
                                    </p>

                                    <div class="reviews-icons">
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                        <i class="bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="reviews-body">
                                <img src="images/left-quote.png" class="quote-icon img-fluid" alt="">

                                <h4 class="reviews-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</h4>
                            </div>
                        </div>
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
                    <h2 class="text-white mb-2">Over 10k opening jobs</h2>

                    <p class="text-white">If you are looking for free HTML templates, you may visit Tooplate website. If you need a collection of free templates, you can visit Too CSS website.</p>
                </div>

                <div class="col-lg-4 col-12 ms-auto">
                    <div class="custom-border-btn-wrap d-flex align-items-center mt-lg-4 mt-2">
                        <a href="register.php" class="custom-btn custom-border-btn btn me-4">Create an account</a>

                        <a href="job-listings.php" class="custom-link">Post a job</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
$file_path = "parts/footer.php";
if(!include_once($file_path)) {
    echo"Failed to include $file_path";
}
?>

</body>
</html>