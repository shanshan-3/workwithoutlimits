<?php
require_once "../includes/session.php";
require_once "../config/database.php";
require_once "../functions/user-functions.php";
include "../includes/header.php";

require_role('employer');

$user_id = $_SESSION['user_id'];
$isSetup = isset($_SESSION['setup']) && $_GET['setup'] === '1';
$error = "";
$success = "";

$profile = get_employer_profile($pdo, $user_id);
$field = fn($key) => htmlspecialchars($profile[$key] ?? '', ENT_QUOTES, 'UTF-8');


?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="../index.php">
            work<span class="text-warning">without</span>limits
        </a>
    </div>
</nav>

<div class="container py-5">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
        <div class="card border-0 shadow">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-1">Setup Profile</h3>
                <p class="text-center text-muted mb-4">Let's set up your employer profile</p>

                <?php if($isSetup): ?>
                    <div class="alert alert-info" role="alert">
                        Welcome! Please complete your company profile to get started.
                    </div>
                <?php endif; ?>

                <form action="profile.php" method="POST">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $field('company_name') ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>