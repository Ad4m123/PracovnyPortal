<?php
session_start();
include_once "../parts/head.php";
require_once "../db/config.php";
require_once "../classes/AdminJob.php";

// Kontrola admin oprávnení
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$adminJobObj = new AdminJob($db);

// Získať spoločnosti a kategórie
$companies = $adminJobObj->getAllCompanies();
$categories = $adminJobObj->getAllCategories();

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validácia údajov
    $formData = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'requirements' => trim($_POST['requirements'] ?? ''),
        'benefits' => trim($_POST['benefits'] ?? ''),
        'salary' => intval($_POST['salary'] ?? 0),
        'level' => trim($_POST['level'] ?? ''),
        'job_type' => trim($_POST['job_type'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'country' => trim($_POST['country'] ?? ''),
        'company_name' => trim($_POST['company_name'] ?? ''),
        'category_id' => intval($_POST['category_id'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0
    ];

    // Validačné pravidlá
    if (empty($formData['title'])) $errors[] = "Job title is required";
    if (empty($formData['description'])) $errors[] = "Description is required";
    if ($formData['salary'] <= 0) $errors[] = "Salary must be a positive number";
    if (empty($formData['level'])) $errors[] = "Level is required";
    if (empty($formData['job_type'])) $errors[] = "Job type is required";
    if (empty($formData['city'])) $errors[] = "City is required";
    if (empty($formData['country'])) $errors[] = "Country is required";
    if (empty($formData['company_name'])) $errors[] = "Company name is required";
    if ($formData['category_id'] <= 0) $errors[] = "Category is required";

    if (empty($errors)) {
        if ($adminJobObj->createJob($formData)) {
            $_SESSION['message'] = "Pracovná ponuka bola úspešne vytvorená!";
            $_SESSION['message_type'] = "success";
            header("Location: ../edit-jobs.php");
            exit;
        } else {
            $errors[] = "Chyba pri vytváraní pracovnej ponuky";
        }
    }
}

$activePage = 'admin';
$pageTitle = 'Add New Job';
$breadcrumbs = [
    ['title' => 'Home', 'link' => '../index.php', 'active' => false],
    ['title' => 'Admin Panel', 'link' => '../edit-jobs.php', 'active' => false],
    ['title' => 'Add Job', 'link' => '', 'active' => true]
];
include_once('../parts/nav.php');
?>

<body id="top">
<?php include_once "../parts/header.php" ?>

<main>
    <section class="job-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <h2 class="mb-4">Add New Job</h2>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="custom-form">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <label for="title" class="form-label">Job Title *</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="<?php echo htmlspecialchars($formData['title'] ?? ''); ?>" required>
                            </div>

                            <div class="col-lg-6 col-12">
                                <label for="company_name" class="form-label">Company *</label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                       value="<?php echo htmlspecialchars($formData['company_name'] ?? ''); ?>"
                                       placeholder="Enter company name" required>
                            </div>

                            <div class="col-lg-6 col-12">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['idcategory']; ?>"
                                            <?php echo (($formData['category_id'] ?? 0) == $category['idcategory']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-12 col-12">
                                <label for="description" class="form-label">Job Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($formData['description'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-lg-12 col-12">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3"><?php echo htmlspecialchars($formData['requirements'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-lg-12 col-12">
                                <label for="benefits" class="form-label">Benefits</label>
                                <textarea class="form-control" id="benefits" name="benefits" rows="3"><?php echo htmlspecialchars($formData['benefits'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-lg-4 col-12">
                                <label for="salary" class="form-label">Salary (USD) *</label>
                                <input type="number" class="form-control" id="salary" name="salary" min="1"
                                       value="<?php echo htmlspecialchars($formData['salary'] ?? ''); ?>" required>
                            </div>

                            <div class="col-lg-4 col-12">
                                <label for="level" class="form-label">Level *</label>
                                <select class="form-select" id="level" name="level" required>
                                    <option value="">Select Level</option>
                                    <option value="Entry Level" <?php echo (($formData['level'] ?? '') == 'Entry Level') ? 'selected' : ''; ?>>Entry Level</option>
                                    <option value="Mid Level" <?php echo (($formData['level'] ?? '') == 'Mid Level') ? 'selected' : ''; ?>>Mid Level</option>
                                    <option value="Senior Level" <?php echo (($formData['level'] ?? '') == 'Senior Level') ? 'selected' : ''; ?>>Senior Level</option>
                                    <option value="Executive" <?php echo (($formData['level'] ?? '') == 'Executive') ? 'selected' : ''; ?>>Executive</option>
                                </select>
                            </div>

                            <div class="col-lg-4 col-12">
                                <label for="job_type" class="form-label">Job Type *</label>
                                <select class="form-select" id="job_type" name="job_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Full-time" <?php echo (($formData['job_type'] ?? '') == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
                                    <option value="Part-time" <?php echo (($formData['job_type'] ?? '') == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
                                    <option value="Contract" <?php echo (($formData['job_type'] ?? '') == 'Contract') ? 'selected' : ''; ?>>Contract</option>
                                    <option value="Remote" <?php echo (($formData['job_type'] ?? '') == 'Remote') ? 'selected' : ''; ?>>Remote</option>
                                </select>
                            </div>

                            <div class="col-lg-6 col-12">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city"
                                       value="<?php echo htmlspecialchars($formData['city'] ?? ''); ?>" required>
                            </div>

                            <div class="col-lg-6 col-12">
                                <label for="country" class="form-label">Country *</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       value="<?php echo htmlspecialchars($formData['country'] ?? ''); ?>" required>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        <?php echo (($formData['is_active'] ?? 1) == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active Job
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="../edit-jobs.php" class="btn btn-secondary">
                                        <i class="bi-arrow-left me-2"></i>Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi-plus-circle me-2"></i>Create Job
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "../parts/footer.php" ?>
</body>