<?php 
require_once '../includes/db.php'; 

// Fetch unread messages count
try {
    $unread_stmt = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read=0");
    $unread_count = $unread_stmt->fetchColumn();
} catch(PDOException $e) {
    $unread_count = 0; // Fallback if table doesn't exist yet
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <?php $admin_css = '../assets/css/style.css'; ?>
    <link rel="stylesheet" href="<?= $admin_css ?>?v=<?= file_exists($admin_css) ? filemtime($admin_css) : time() ?>">
    <style>
        .admin-sidebar {
            background: linear-gradient(180deg, var(--surface-color) 0%, rgba(20,20,30,1) 100%);
            min-height: 100vh;
            border-right: 1px solid rgba(255,255,255,0.05);
            box-shadow: 4px 0 25px rgba(0,0,0,0.3);
            z-index: 1000;
        }
        @media (min-width: 768px) {
            .admin-sidebar {
                position: fixed !important;
                top: 0;
                bottom: 0;
            }
        }
        @media (max-width: 767.98px) {
            .admin-sidebar {
                position: fixed !important;
                top: 0;
                left: -300px;
                width: 280px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease-in-out;
            }
            .admin-sidebar.show {
                left: 0;
            }
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.6);
                backdrop-filter: blur(4px);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease-in-out;
            }
            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }
            .table-custom th, .table-custom td {
                padding: 0.75rem 1rem !important;
                white-space: nowrap;
            }
            h3 {
                font-size: 1.5rem !important;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        .admin-nav .nav-link {
            color: rgba(255,255,255,0.6) !important;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 4px 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .admin-nav .nav-link i {
            width: 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            color: rgba(255,255,255,0.5);
        }
        .admin-nav .nav-link:hover {
            background-color: rgba(123, 44, 191, 0.1);
            color: white !important;
            transform: translateX(6px);
        }
        .admin-nav .nav-link:hover i {
            color: var(--primary-color);
            transform: scale(1.15);
        }
        .admin-nav .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, rgba(90, 24, 154, 1) 100%);
            color: white !important;
            box-shadow: 0 4px 15px rgba(123, 44, 191, 0.4);
            transform: translateX(6px);
        }
        .admin-nav .nav-link.active i {
            color: white;
        }
        
        .admin-nav .nav-link.text-danger {
            color: #ff4d4d !important;
            background-color: rgba(255, 77, 77, 0.05);
            margin-top: auto;
        }
        .admin-nav .nav-link.text-danger i {
            color: #ff4d4d;
        }
        .admin-nav .nav-link.text-danger:hover {
            background-color: rgba(255, 77, 77, 0.15);
            box-shadow: 0 4px 15px rgba(255, 77, 77, 0.2);
        }
        
        .admin-logo-container {
            padding: 24px 20px;
            margin-bottom: 10px;
            position: relative;
        }
        .admin-logo-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 1px;
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%);
        }
        .admin-logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-logo-text span.brand-admin {
            color: white;
        }
        .admin-logo-text span.brand-panel {
            background: linear-gradient(135deg, var(--primary-color), #b070ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-control, .form-select {
            background-color: transparent !important;
            border-color: rgba(255,255,255,0.1) !important;
            color: white !important;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(123, 44, 191, 0.25);
            border-color: var(--primary-color) !important;
        }
        .form-select option {
            background-color: #1a1a24;
            color: white;
        }
        .table-custom {
            color: white;
            border-color: rgba(255,255,255,0.1);
        }
        .table-custom th, .table-custom td {
            background-color: transparent;
            border-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="sidebar-overlay d-md-none" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 admin-sidebar d-flex flex-column" id="adminSidebar">
            <div class="admin-logo-container d-flex justify-content-between align-items-center">
                <h4 class="admin-logo-text mb-0">
                    <img src="../assets/images/logo.png" alt="MD Logo" style="height: 35px; border-radius: 6px; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);">
                    <div>
                        <span class="brand-admin">Mark</span><span class="brand-panel">Dale</span>
                    </div>
                </h4>
                <button type="button" class="btn-close btn-close-white d-md-none" onclick="toggleSidebar()" aria-label="Close"></button>
            </div>
            <ul class="nav flex-column admin-nav flex-grow-1 py-2">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="./"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>" href="settings"><i class="fas fa-cog"></i> Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'active' : '' ?>" href="skills"><i class="fas fa-star"></i> Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : '' ?>" href="projects"><i class="fas fa-briefcase"></i> Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'experience.php' ? 'active' : '' ?>" href="experience"><i class="fas fa-history"></i> Experience</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'certificates.php' ? 'active' : '' ?>" href="certificates"><i class="fas fa-certificate"></i> Certificates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : '' ?>" href="services.php"><i class="fas fa-concierge-bell"></i> Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center <?= basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : '' ?>" href="messages.php">
                        <span><i class="fas fa-envelope"></i> Messages</span>
                        <?php if($unread_count > 0): ?>
                            <span class="badge bg-danger rounded-pill shadow-sm"><?= $unread_count ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item mt-auto mb-4 border-top pt-3" style="border-color: rgba(255,255,255,0.05) !important; margin-inline: 16px;">
                    <a class="nav-link text-danger m-0" href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="col-12 col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-0">
            <nav class="navbar navbar-dark bg-transparent border-bottom px-3 px-md-4 py-2 py-md-3" style="border-color: rgba(255,255,255,0.05) !important;">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <button class="btn btn-outline-light d-md-none border-0 px-2" type="button" onclick="toggleSidebar()">
                            <i class="fas fa-bars fs-5"></i>
                        </button>
                        <h5 class="mb-0 text-white d-none d-sm-block">Manage Portfolio</h5>
                    </div>
                    <a href="../" target="_blank" class="btn btn-outline-custom btn-sm"><i class="fas fa-external-link-alt me-1 me-md-2"></i><span class="d-none d-sm-inline">View Site</span></a>
                </div>
            </nav>
            <div class="p-3 p-md-4 p-lg-5" style="min-height: calc(100vh - 70px);">
