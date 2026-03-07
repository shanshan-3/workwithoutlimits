<?php
require_once '../includes/session.php';
require_once '../config/database.php';
require_once '../functions/user-functions.php';
include '../includes/header.php';

require_role('seeker');

$stmt = $pdo->prepare("SELECT full_name FROM seeker_profiles WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    header("Location: profile.php?setup=1");
    exit();
}
$applications = [];
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

<div class="container py-5 mt-5">
    <h1 class="display-5 fw-bold"> WELCOME ,
        <span class="text-warning"><?php echo htmlspecialchars($profile['full_name']); ?></span>
    </h1>
    <p class="lead text-secondary mt-3 mb-4">
        This is your dashboard where you can manage your profile, view job applications, and explore new opportunities.
    </p>

</div>