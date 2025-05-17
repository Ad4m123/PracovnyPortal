<?php
include_once "parts/head.php";
require_once "db/login_process.php";

$activePage = 'login';
$pageTitle = 'Login';
$breadcrumbs = [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => 'Login', 'link' => '', 'active' => true]
];
include_once('parts/nav.php');
?>

<body id="top">

<?php
$activePage = 'login';
include_once('parts/nav.php');
?>

<main>
    <?php include_once('parts/head.php')?>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-12 mx-auto">
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
                        <h4 class="text-center mb-4">Access Your Account</h4>

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="your@email.com" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>

                            <div class="col-lg-12 col-12">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            </div>

                            <div class="col-lg-4 col-md-4 col-6 mx-auto">
                                <button type="submit" class="form-control">Login</button>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <p>Don't have an account? <a href="register.php">Register here</a></p>
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
                    <h2 class="text-white mb-2">Find your dream job today</h2>
                    <p class="text-white">Login to access your job applications, saved jobs, and personalized job recommendations.</p>
                </div>

                <div class="col-lg-4 col-12 ms-auto">
                    <div class="custom-border-btn-wrap d-flex align-items-center mt-lg-4 mt-2">
                        <a href="register.php" class="custom-btn custom-border-btn btn me-4">Create Account</a>
                        <a href="job-listings.php" class="custom-link">Browse Jobs</a>
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