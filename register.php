<?php
include_once "parts/header.php";
require_once "db/config.php";

$first_name = $last_name = $email = $password = $confirm_password = "";
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first-name']);
    $last_name = trim($_POST['last-name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];


    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long";
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $check_query = "SELECT id FROM user WHERE email = :email";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $error_message = "Email already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO user (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

            $insert_stmt = $db->prepare($insert_query);

            $insert_stmt->bindParam(':first_name', $first_name);
            $insert_stmt->bindParam(':last_name', $last_name);
            $insert_stmt->bindParam(':email', $email);
            $insert_stmt->bindParam(':password', $hashed_password);


            if ($insert_stmt->execute()) {
                $success_message = "Registration successful! You can now <a href='login.php'>login</a>";
                $first_name = $last_name = $email = $password = $confirm_password = "";
            } else {
                $error_message = "Something went wrong. Please try again later.";
            }
        }
    }
}
?>

<body id="top">

<?php
$activePage = 'register';
include_once('parts/nav.php');
?>

<main>
    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">Register</h1>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Register</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </header>

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