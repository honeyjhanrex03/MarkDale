<?php 
require_once 'includes/auth.php';
require_once '../includes/db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_settings') {
    $site_title = $_POST['site_title'];
    $hero_title = $_POST['hero_title'];
    $hero_name = $_POST['hero_name'];
    $objective = $_POST['objective'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    
    $stmt = $pdo->prepare("UPDATE settings SET 
        site_title = ?, 
        hero_title = ?, 
        hero_name = ?, 
        objective = ?, 
        email = ?, 
        phone = ?, 
        location = ?, 
        linkedin = ?, 
        github = ?
    ");
    $stmt->execute([$site_title, $hero_title, $hero_name, $objective, $email, $phone, $location, $linkedin, $github]);
    
    $_SESSION['success_msg'] = 'Settings updated successfully!';
    header("Location: settings.php");
    exit;
}

// Fetch current settings
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$settings) {
    // Should exist from db.php default seed, but just in case
    $pdo->exec("INSERT INTO settings (objective) VALUES ('')");
    $settings = $pdo->query("SELECT * FROM settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);
}

require_once 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold mb-0">Global Settings</h3>
</div>

<div class="custom-card p-4">
    <form method="POST">
        <input type="hidden" name="action" value="update_settings">
        
        <h5 class="text-white mb-4"><i class="fas fa-globe text-primary me-2"></i>Site Information</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted small">Site Title (Browser Tab)</label>
                <input type="text" name="site_title" class="form-control" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small">Hero Name (Big Title on Homepage)</label>
                <input type="text" name="hero_name" class="form-control" value="<?= htmlspecialchars($settings['hero_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-12">
                <label class="form-label text-muted small">Hero Subtitle</label>
                <input type="text" name="hero_title" class="form-control" value="<?= htmlspecialchars($settings['hero_title'] ?? '') ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label text-muted small">Objective / About Text</label>
                <textarea name="objective" class="form-control" rows="4" required><?= htmlspecialchars($settings['objective'] ?? '') ?></textarea>
            </div>
        </div>

        <h5 class="text-white mb-4 mt-5"><i class="fas fa-address-card text-primary me-2"></i>Contact Information</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted small">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($settings['email'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small">Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label text-muted small">Location Address</label>
                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($settings['location'] ?? '') ?>">
            </div>
        </div>

        <h5 class="text-white mb-4 mt-5"><i class="fas fa-link text-primary me-2"></i>Social Links</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted small">LinkedIn URL</label>
                <input type="url" name="linkedin" class="form-control" value="<?= htmlspecialchars($settings['linkedin'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small">GitHub URL</label>
                <input type="url" name="github" class="form-control" value="<?= htmlspecialchars($settings['github'] ?? '') ?>">
            </div>
        </div>

        <div class="border-top pt-4 mt-4" style="border-color: rgba(255,255,255,0.05) !important;">
            <button type="submit" class="btn btn-primary-custom px-5 py-2">Save Settings</button>
        </div>
    </form>
</div>

<?php if(isset($_SESSION['success_msg'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '<?= addslashes($_SESSION['success_msg']) ?>',
        background: 'var(--surface-color)',
        color: 'white',
        confirmButtonColor: 'var(--primary-color)'
    });
});
</script>
<?php unset($_SESSION['success_msg']); endif; ?>

<?php require_once 'includes/footer.php'; ?>
