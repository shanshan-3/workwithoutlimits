<?php
require_once '../includes/session.php';
require_once '../config/database.php';
require_once '../functions/user-functions.php';

require_role('seeker');

$stmt = $pdo->prepare("
    SELECT full_name 
    FROM seeker_profiles 
    WHERE user_id = ?"
);
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    header("Location: profile.php?setup=1");
    exit();
}
include '../includes/header.php';

try {
    $stmt = $pdo->prepare("
        SELECT a.job_id, a.status, a.applied_at
        FROM applications a
        WHERE a.user_id = ?
        ORDER BY a.applied_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $applications = [];
}
?>
<?php include '../includes/navbar.php'; ?>

<div class="container py-4">
    <div class="welcome-banner p-4 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h2 class="mb-1">WELCOME, <span><?= htmlspecialchars($profile['full_name']) ?></span> !</h2>
            <p class="mb-0">This is your dashboard. Manage your profile, view applications, and explore new opportunities.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-warning fw-bold text-dark"><i class="bi bi-search me-1"></i>Browse Jobs</a>
        </div>
    </div>

    <div class="card-body d-flex align-items-center gap-3">

    </div>
</div>