<?php
require_once '../config/database.php';
require_once '../includes/session.php';
require_once '../functions/user-functions.php';
require_once '../functions/job-functions.php';
require_once '../includes/header.php';

require_role('seeker');

$filters = [];
$jobs = get_jobs($pdo, $filters);


?>
<?php require_once '../includes/navbar.php'; ?>

<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold mb-1"><i class="bi bi-briefcase text-dark me-2"></i>Browse Jobs</h3>
        <p class="text-muted small mb-0">Find jobs that match your skills and accessibility needs.</p>
    </div>
    <!-- FILTER BAR -->
    <div class="filter-bar card bg-dark p-3 mb-4 shadow bg-white rounded-3">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <i class="bi bi-search text-muted"></i>
                <label class="mb-0 text-muted fw-semibold">Keyword Search</label>
                <input type="text" class="form-control form-control-sm mt-1" id="keywordSearch" placeholder="Search by title or description...">
            </div>
            <div class="col-12 col-md-3">
                <i class="bi bi-geo-alt text-muted"></i>
                <label class="mb-0 text-muted fw-semibold">Arrangement</label>
                <select type="dropdown" class="form-select form-select-sm mt-1" id="arrangementFilter">
                    <option value="" selected>All Arrangements</option>
                    <option value="remote">Remote</option>
                    <option value="onsite">On-site</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <i class="bi bi-clock me-1"></i>
                <label class="mb-0 text-muted fw-semibold">Work Type</label>
                <select type="dropdown" class="form-select form-select-sm mt-1" id="workTypeFilter">
                    <option value="" selected>All Types</option>
                    <option value="fulltime">Full-time</option>
                    <option value="parttime">Part-time</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>
            <div class="col-12 col-md-1 d-flex align-items-end">
                <button class="btn w-100 " id="clearFilters">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    </div>


    <div id="jobHead" class="row g-4">
        <div class="container py-4">
            <h3 class="fw-bold mb-1"><i class="bi bi-briefcase text-dark me-2"></i>Jobs</h3>
            <p class="text-muted small mb-0">Explore the latest job postings that match your skills and preferences.</p>
        </div>
    </div>

    <!-- JOBS LISTINGS -->
    <div id="jobListings" class="row g-4">
        <?php if (empty($jobs)): ?>
            <div class="col-12 py-5 text-center">
                <div class="card bg-light p-5 border-0 shadow-sm">
                    <i class="bi bi-briefcase text-muted mb-3" style="font-size: 2.5rem; display: block;"></i>
                    <h4 class="text-muted">No jobs found</h4>
                    <p class="text-muted mb-0">Try adjusting your filters or check back later for new postings.</p>
                </div>
            </div>
        <?php else: ?>
        <?php foreach ($jobs as $job): ?>
            <div class="col-12 col-md-6 col-lg-4 job-item"
                data-title="<?php echo htmlspecialchars($job['title']); ?>" 
                data-description="<?php echo htmlspecialchars($job['description'] ?? ''); ?>"
                data-arrangement="<?php echo htmlspecialchars($job['arrangement']); ?>" 
                data-worktype="<?php echo htmlspecialchars($job['work_type']); ?>">
                
                <div class="card job-card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column gap-3">
                        
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="bg-primary bg-opacity-10 p-2 rounded text-dark">
                                <i class="bi bi-building-fill" style="font-size: 1.25rem;"></i>
                            </div>
                            <!-- <span class="filter-match badge bg-secondary"></span> -->
                        </div>

                        <div>
                            <h5 class="card-title fw-bold mb-1">
                                <?php echo htmlspecialchars($job['title']); ?>
                            </h5>
                            <div class="job-company text-muted small">
                                <i class="bi bi-building me-1"></i>
                                <?php echo htmlspecialchars($job['company_name']); ?>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge <?php echo $job['arrangement'] == 'remote' ? 'bg-info' : ($job['arrangement'] == 'onsite' ? 'bg-light text-dark border' : 'bg-warning'); ?> fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>
                                <?php echo htmlspecialchars($job['arrangement'] == 'hybrid' ? 'Hybrid' : ucfirst($job['arrangement'])); ?>
                            </span>

                            <span class="badge <?php echo $job['work_type'] == 'fulltime' ? 'bg-primary' : ($job['work_type'] == 'parttime' ? 'bg-secondary' : 'bg-dark'); ?> fw-semibold">
                                <i class="bi bi-clock me-1"></i>
                                <?php echo htmlspecialchars(ucfirst($job['work_type'])); ?>
                            </span>
                        </div>

                        <div class="job-posted text-muted small mt-1">
                            <i class="bi bi-calendar3 me-1"></i>
                            Posted <?php echo date('M d, Y', strtotime($job['created_at'])); ?>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <button class="btn btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#jobModal">View Details</button>
                            <button class="btn btn-dark btn-sm flex-fill text-warning fw-bold">Apply Now</button>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
</div>