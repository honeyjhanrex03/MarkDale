<?php
session_start();
require_once '../includes/db.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: ./');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['login_success'] = true;
        header('Location: ./');
        exit;
    } else {
        $_SESSION['login_error'] = 'Invalid username or password.';
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= filemtime('../assets/css/style.css') ?>">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="custom-card p-5 shadow-lg" style="width: 100%; max-width: 400px; border-top: 4px solid var(--primary-color) !important;">
        <div class="text-center mb-4">
            <img src="../assets/images/logo.png" alt="MD Logo" class="mb-3" style="height: 50px; border-radius: 8px;">
            <h3 class="fw-bold text-white mb-1">Admin Login</h3>
            <p class="text-muted small">Enter credentials to manage portfolio</p>
        </div>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">Username</label>
                <input type="text" name="username" class="form-control bg-transparent text-white" style="border-color: rgba(255,255,255,0.1);" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">Password</label>
                <input type="password" name="password" class="form-control bg-transparent text-white" style="border-color: rgba(255,255,255,0.1);" required>
            </div>
            <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold">Login to Dashboard</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php if(isset($_SESSION['login_error'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: '<?= htmlspecialchars($_SESSION['login_error'], ENT_QUOTES) ?>',
            confirmButtonColor: 'var(--primary-color)',
            background: 'var(--surface-color)',
            color: 'white'
        });
    });
    </script>
    <?php unset($_SESSION['login_error']); endif; ?>

    <?php if(isset($_SESSION['logout_success'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Logged Out',
            text: 'You have been safely logged out.',
            confirmButtonColor: 'var(--primary-color)',
            background: 'var(--surface-color)',
            color: 'white',
            timer: 2500,
            showConfirmButton: false
        });
    });
    </script>
    <?php unset($_SESSION['logout_success']); endif; ?>
</body>
</html>
