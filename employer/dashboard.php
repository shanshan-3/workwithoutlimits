<?php
require_once '../includes/session.php';
require_once '../config/database.php';
require_once '../functions/user-functions.php';

require_role('employer');

$stmt = $pdo->prepare(
    "
    SELECT * 
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

try {
    $stmt = $pdo->prepare("
        SELECT j.job_id, j.title, j.created_at
        FROM job_posting j
        WHERE j.employer_id = ?
        ORDER BY j.created_at DESC
        AND status = 'active'
    ");
    $stmt->execute([$profile['profile_id']]);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $jobs = [];
}
try {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM applications a
        JOIN job_posting j ON a.job_id = j.job_id
        WHERE j.employer_id = ?
    ");
    $stmt->execute([$profile['profile_id']]);
    $application_count = $stmt->fetchColumn();
} catch (PDOException $e) {
    $application_count = 0;
}

$closed_jobs = count(array_filter($jobs, fn($j) => $j['status'] === 'closed'));

?>
<?php include '../includes/navbar.php'; ?>

<div class="container py-4">
    <div class="welcome-banner p-4 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h2 class="mb-1">WELCOME, <span><?= htmlspecialchars($profile['company_name']) ?></span> !</h2>
            <p class="mb-0">This is your dashboard. Manage your profile, view job postings, and explore new opportunities.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="post-job.php" class="btn btn-warning fw-bold text-dark"><i class="bi bi-plus me-1"></i>Post a Job</a>
        </div>
    </div>
<!-- STATS CARD -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">
            <div class="card stat-card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="bi bi-briefcase text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-primary fw-bold"><?= count($jobs) ?></div>
                        <div class="text-muted small fw-medium">Active Job Posts</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card stat-card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="bi bi-people-fill text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning fw-bold"><?= $application_count ?></div>
                        <div class="text-muted small fw-medium">Total Applications</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card stat-card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-secondary bg-opacity-10">
                        <i class="bi bi-archive-fill text-secondary"></i>
                    </div>
                    <div>
                        <div class="stat-value text-secondary fw-bold"><?= $closed_jobs ?></div>
                        <div class="text-muted small fw-medium">Closed Jobs</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- JOB POSTING PAGE -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Job Postings</h5>
        <div class="card-jobs">
            <a href="post-job.php" class="btn btn-warning fw-bold text-dark"><i class="bi bi-plus me-1"></i>Post a Job</a>
        </div>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body p-0">
            <?php if(count($jobs) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>JOB TITLE</th>
                            <th>WORK TYPE</th>
                            <th>ARRANGEMENT</th>
                            <th>APPLICANTS</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($jobs as $job): ?>
                        <tr>
                            <td><?= htmlspecialchars($job['title']) ?></td>
                            <td><?= htmlspecialchars($job['work_type']) ?></td>
                            <td><?= htmlspecialchars($job['arrangement']) ?></td>
                            <td><?= $job['applicant_count'] ?></td>
                            <td>
                                <?php if($job['status'] === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Closed</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit-job.php?id=<?= $job['job_id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <a href="delete-job.php?id=<?= $job['job_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job?');"><i class="bi bi-trash"></i></a>
                                <a href="applicantions.php?job_id=<?= $job['job_id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center p-4">
                <i class="bi bi-briefcase text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3 mb-0">No job postings found. Start by posting your first job!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>