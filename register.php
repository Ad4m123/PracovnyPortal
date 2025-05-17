<?php
include_once "parts/head.php";
require_once "db/register_process.php";
?>

<body id="top">

<?php
$activePage = 'register';
$pageTitle = 'Register';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Register', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<main>
    <?php include_once('parts/header.php')?>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 mx-auto">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success text-center">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>

                    <form class="custom-form contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form">
                        <h4 class="text-center mb-4">Create Your Account</h4>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="first-name">First Name</label>
                                <input type="text" name="first-name" id="first-name" class="form-control" placeholder="Name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="last-name">Last Name</label>
                                <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Surname" value="<?php echo htmlspecialchars($last_name); ?>" required>
                            </div>

                            <div class="col-lg-12 col-12">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="your@email.com" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="confirm-password">Confirm Password</label>
                                <input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Confirm your password" required>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-6 mx-auto">
                                <button type="submit" class="form-control">Register</button>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <p>Already have an account? <a href="login.php">Login here</a></p>
                            </div>
                        </div>
                    </form>
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
                    <p class="text-white">Join our community of job seekers and employers. Create an account today to start your journey with Gotto Job Portal.</p>
                </div>

                <div class="col-lg-4 col-12 ms-auto">
                    <div class="custom-border-btn-wrap d-flex align-items-center mt-lg-4 mt-2">
                        <a href="job-listings.php" class="custom-btn custom-border-btn btn me-4">Browse Jobs</a>
                        <a href="contact.php" class="custom-link">Contact Us</a>
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