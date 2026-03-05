<?php
include '../includes/header.php';
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
                <h3 class="text-center fw-bold mb-1">Setup Your Profile</h3>
                <p class="text-center text-muted mb-4">Let's set up your jobseeker profile</p>

                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <input type="text" name="skills" id="skills" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="accessibility_needs" class="form-label">Accessibility Needs</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" name="accessibility_needs[]" value="wheelchair" class="form-check-input"> Wheelchair Accessible Office
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="resume" class="form-label">Upload Resume</label>
                        <input type="file" name="resume" id="resume" class="form-control" accept=".pdf,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg text-dark fw-bold w-100">Save Profile</button>
                </form>
            </div>
        </div>
    </div>