<?php
require_once '../includes/session.php';
require_once '../config/database.php';
require_once '../functions/user-functions.php';

require_role('employer');

$stmt = $pdo->prepare("
    SELECT profile_id 
    FROM employer_profiles 
    WHERE user_id = ?"
);
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    header("Location: profile.php?setup=1");
    exit();
}
include '../includes/header.php';

try{
    $stmt = $pdo->prepare("
        SELECT j.job_id, j.title, j.created_at
        FROM job_posting j
        WHERE j.employer_id = ?
        ORDER BY j.created_at DESC
    ");
    $stmt->execute([$profile['profile_id']]);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $jobs = [];
}
?>
<?php include '../includes/navbar.php'; ?>

<div class="container py-4">
    <div class="welcome-banner p-4 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h2 class="mb-1">WELCOME, <span><?= htmlspecialchars($_SESSION['username']) ?></span> !</h2>
            <p class="mb-0">This is your dashboard. Manage your profile, view job postings, and explore new opportunities.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="post-job.php" class="btn btn-warning fw-bold text-dark"><i class="bi bi-plus me-1"></i>Post a Job</a>
        </div>
    </div>

    <div class="card-body d-flex align-items-center gap-3">
        
</div>