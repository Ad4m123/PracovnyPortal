<?php
include_once "parts/header.php";
require_once "db/config.php";

$email = $password = "";
$error_message = "";
$success_message = "";

session_start();

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } else {

        $database = new Database();
        $db = $database->getConnection();

        $query = "SELECT id, first_name, last_name, email, password, is_admin FROM user WHERE email = :email";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':email', $email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {
                // Password is correct, create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['is_admin'] = $user['is_admin'];

                header("Location: index.php");
                exit;
            } else {
                $error_message = "Invalid email or password";
            }
        } else {
            $error_message = "Invalid email or password";
        }
    }
}
?>

<body id="top">

<?php
$activePage = 'login';
include_once('parts/nav.php');
?>

<main>
    <header class="site-header">
        <div class="section-overlay"></div>

        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h1 class="text-white">Login</h1>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Login</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </header>

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