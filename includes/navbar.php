<?php
$role = $_SESSION['role'] ?? 'guest';
$name = $_SESSION['user']['name'] ?? '';
$current = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand fw-bold" href="index.php">
      work<span class="text-warning font-">without</span>limits
    </a>

    <?php if ($role !== 'guest'): ?>
      <button class="navbar-toggler" type="button"
              data-bs-toggle="collapse"
              data-bs-target="#mainNav"
              aria-controls="mainNav"
              aria-expanded="false"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <?php endif; ?>

    <div class="collapse navbar-collapse" id="mainNav">

      <?php if ($role === 'guest'): ?>

        <ul class="navbar-nav ms-auto align-items-center gap-2">
          <li class="nav-item">
            <a class="nav-link <?= $current==='index.php'?'active':'' ?>" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm" href="auth/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-warning btn-sm bi bi-person text-dark fw-semibold" href="auth/register.php"> Sign up</a>
          </li>
        </ul>

      <?php elseif ($role === 'seeker'): ?>

        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link <?= $current==='dashboard.php'?'active':'' ?>" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current==='browse_jobs.php'?'active':'' ?>" href="browse_jobs.php">Browse Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current==='my_applications.php'?'active':'' ?>" href="my_applications.php">My Applications</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center gap-2">
          <li class="nav-item">
            <a class="nav-link <?= $current==='profile.php'?'active':'' ?>" href="profile.php">
              <i class="bi bi-person-circle"></i> <?= htmlspecialchars($name) ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a>
          </li>
        </ul>

      <?php elseif ($role === 'employer'): ?>

        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link <?= $current==='dashboard.php'?'active':'' ?>" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current==='post_job.php'?'active':'' ?>" href="post_job.php">Post a Job</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current==='my_jobs.php'?'active':'' ?>" href="my_jobs.php">My Jobs</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center gap-2">
          <li class="nav-item">
            <a class="nav-link <?= $current==='profile.php'?'active':'' ?>" href="profile.php">
              <i class="bi bi-person-circle"></i> <?= htmlspecialchars($name) ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a>
          </li>
        </ul>

      <?php endif; ?>

    </div>
  </div>
</nav>