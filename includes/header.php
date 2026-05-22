<?php 
require_once 'includes/db.php'; 
// Fetch settings
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);
$current_page = basename($_SERVER['PHP_SELF']);

// Track page view
try {
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("INSERT INTO page_views (view_date, views) VALUES (?, 1) ON DUPLICATE KEY UPDATE views = views + 1");
    $stmt->execute([$today]);
} catch(PDOException $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_title'] ?? 'Portfolio') ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <?php $css_file = 'assets/css/style.css'; ?>
    <link rel="stylesheet" href="<?= $css_file ?>?v=<?= file_exists($css_file) ? filemtime($css_file) : time() ?>">
</head>
<body>

<nav class="navbar navbar-expand-xl navbar-dark navbar-custom sticky-top py-3">
  <div class="container">
    <!-- Brand strictly mimicking the image -->
    <a class="navbar-brand d-flex align-items-center" href="./">
      <img src="assets/images/logo.png" alt="MD Logo" style="height: 50px; width: auto; border-radius: 8px;">
    </a>
    
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <i class="fas fa-bars fs-3 text-white"></i>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto align-items-center gap-2 gap-xl-4 mt-3 mt-xl-0">
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="./">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'about.php' ? 'active' : '' ?>" href="about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'skills.php' ? 'active' : '' ?>" href="skills">Skills</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'services.php' ? 'active' : '' ?>" href="services">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'projects.php' ? 'active' : '' ?>" href="projects">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'experience.php' ? 'active' : '' ?>" href="experience">Experience</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'certifications.php' ? 'active' : '' ?>" href="certifications">Certifications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>" href="contact">Contact</a>
        </li>
      </ul>
      <div class="d-flex align-items-center mt-3 mt-xl-0">
        <a class="btn btn-outline-custom px-4 py-2" href="cv" target="_blank"><i class="fas fa-download me-2"></i> Download CV</a>
      </div>
    </div>
  </div>
</nav>
