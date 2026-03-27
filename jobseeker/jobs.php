<?php
require_once '../config/database.php';
require_once '../includes/session.php';
require_once '../functions/user-functions.php';
require_once '../functions/job-functions.php';
require_once '../includes/header.php';

require_role('seeker');
?>
<?php require_once '../includes/navbar.php'; ?>

<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold mb-1"><i class="bi bi-briefcase text-dark me-2"></i>Browse Jobs</h3>
        <p class="text-muted small mb-0">Find jobs that match your skills and accessibility needs.</p>
    </div>
    <!-- FILTER BAR -->
    <div class="filter-bar p-3 mb-4 shadow-sm bg-white rounded">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <i class="bi bi-search text-muted"></i>
                <label class="mb-0 text-muted fw-semibold">Keyword Search</label>
                <input type="text" class="form-control form-control-sm mt-1" id="keywordSearch" placeholder="Search by title or description...">
            </div>
            <div class="col-12 col-md-5">
                <i class="bi bi-geo-alt text-muted"></i>
                <label class="mb-0 text-muted fw-semibold">Arrangement</label>
                <select type="dropdown" class="form-select form-select-sm mt-1" id="arrangementFilter">
                    <option value="" selected>All Arrangements</option>
                    <option value="remote">Remote</option>
                    <option value="onsite">On-site</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <i class="bi bi-clock me-1"></i>
                <label class="mb-0 text-muted fw-semibold">Work Type</label>
                <select type="dropdown" class="form-select form-select-sm mt-1" id="workTypeFilter">
                    <option value="" selected>All Types</option>
                    <option value="fulltime">Full-time</option>
                    <option value="parttime">Part-time</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>
        </div>
    </div>
</div>