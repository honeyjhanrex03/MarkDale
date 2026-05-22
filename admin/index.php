<?php
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Get counts for dashboard
$skills_count = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
$projects_count = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$exp_count = $pdo->query("SELECT COUNT(*) FROM experience")->fetchColumn();
$services_count = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$cert_count = $pdo->query("SELECT COUNT(*) FROM experience WHERE type='certification'")->fetchColumn();

// Message stats
$unread_msg_count = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read=0")->fetchColumn();
$read_msg_count = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read=1")->fetchColumn();

// Recent Unread Messages
$recent_messages = $pdo->query("SELECT * FROM messages WHERE is_read=0 ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Fetch last 7 days of page views
$chart_labels = [];
$chart_data = [];
try {
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $stmt = $pdo->prepare("SELECT views FROM page_views WHERE view_date = ?");
        $stmt->execute([$date]);
        $views = $stmt->fetchColumn();
        
        $chart_labels[] = date('M d', strtotime($date));
        $chart_data[] = $views ? (int)$views : 0;
    }
} catch(PDOException $e) {}
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
    <div>
        <h3 class="text-white fw-bold mb-1">Dashboard Overview</h3>
        <p class="text-muted small mb-0">Welcome back, <?= htmlspecialchars($_SESSION['admin_username']) ?>. Here is what's happening with your portfolio today.</p>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-5">
    <!-- Projects -->
    <div class="col-sm-6 col-xl-3">
        <div class="custom-card p-4 h-100 d-flex align-items-center" style="border-radius: 16px;">
            <div class="d-flex align-items-center justify-content-center rounded-3 me-4" style="width: 56px; height: 56px; background-color: rgba(139, 92, 246, 0.1); color: var(--primary-color);">
                <i class="fas fa-briefcase fa-xl"></i>
            </div>
            <div>
                <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing: 1px;">Total Projects</p>
                <h3 class="text-white fw-bold mb-0"><?= $projects_count ?></h3>
            </div>
        </div>
    </div>
    <!-- Services -->
    <div class="col-sm-6 col-xl-3">
        <div class="custom-card p-4 h-100 d-flex align-items-center" style="border-radius: 16px;">
            <div class="d-flex align-items-center justify-content-center rounded-3 me-4" style="width: 56px; height: 56px; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-concierge-bell fa-xl"></i>
            </div>
            <div>
                <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing: 1px;">Total Services</p>
                <h3 class="text-white fw-bold mb-0"><?= $services_count ?></h3>
            </div>
        </div>
    </div>
    <!-- Messages -->
    <div class="col-sm-6 col-xl-3">
        <div class="custom-card p-4 h-100 d-flex align-items-center" style="border-radius: 16px;">
            <div class="d-flex align-items-center justify-content-center rounded-3 me-4" style="width: 56px; height: 56px; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <i class="fas fa-envelope fa-xl"></i>
            </div>
            <div>
                <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing: 1px;">Unread Inbox</p>
                <h3 class="text-white fw-bold mb-0"><?= $unread_msg_count ?></h3>
            </div>
        </div>
    </div>
    <!-- Skills -->
    <div class="col-sm-6 col-xl-3">
        <div class="custom-card p-4 h-100 d-flex align-items-center" style="border-radius: 16px;">
            <div class="d-flex align-items-center justify-content-center rounded-3 me-4" style="width: 56px; height: 56px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-star fa-xl"></i>
            </div>
            <div>
                <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing: 1px;">Total Skills</p>
                <h3 class="text-white fw-bold mb-0"><?= $skills_count ?></h3>
            </div>
        </div>
    </div>
</div>



<!-- Analytics Chart -->
<div class="row mb-5">
    <div class="col-12">
        <div class="custom-card p-4 p-lg-5" style="border-radius: 16px;">
            <h5 class="text-white fw-bold mb-4">Visitor Analytics (Last 7 Days)</h5>
            <div style="height: 300px;">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Unread Messages -->
<div class="row mb-4">
    <div class="col-12">
        <div class="custom-card p-4 p-lg-5" style="border-radius: 16px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white fw-bold mb-0">Recent Unread Messages</h5>
                <a href="messages.php" class="btn btn-sm btn-outline-light">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0 table-hover align-middle">
                    <thead style="background-color: rgba(255,255,255,0.02);">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold border-0 rounded-start">Date</th>
                            <th class="px-4 py-3 text-muted fw-semibold border-0">Sender</th>
                            <th class="px-4 py-3 text-muted fw-semibold border-0">Subject</th>
                            <th class="px-4 py-3 text-muted fw-semibold border-0 rounded-end text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recent_messages as $msg): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td class="px-4 py-3 text-white small"><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                            <td class="px-4 py-3 text-white fw-medium"><?= htmlspecialchars($msg['name']) ?></td>
                            <td class="px-4 py-3 text-muted small"><?= htmlspecialchars($msg['subject']) ?></td>
                            <td class="px-4 py-3 text-end">
                                <a href="messages.php" class="btn btn-sm btn-outline-light px-3" style="border-color: rgba(255,255,255,0.1);">Read</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(count($recent_messages) == 0): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small border-0">
                                <i class="fas fa-check-circle fs-2 text-success opacity-50 mb-3"></i><br>
                                No new messages! You're all caught up.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php if(isset($_SESSION['login_success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Welcome Back!',
        text: 'You have successfully logged into your dashboard.',
        confirmButtonColor: 'var(--primary-color)',
        background: 'var(--surface-color)',
        color: 'white',
        timer: 3000,
        showConfirmButton: false
    });
});
</script>
<?php unset($_SESSION['login_success']); endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('visitorChart').getContext('2d');
    
    // Gradient fill
    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(123, 44, 191, 0.5)');
    gradient.addColorStop(1, 'rgba(123, 44, 191, 0.0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Page Views',
                data: <?= json_encode($chart_data) ?>,
                borderColor: '#7b2cbf',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#7b2cbf',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: 'rgba(255, 255, 255, 0.5)', stepSize: 1, precision: 0 }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: 'rgba(255, 255, 255, 0.5)' }
                }
            }
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
