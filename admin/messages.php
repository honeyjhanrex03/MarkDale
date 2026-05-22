<?php 
require_once 'includes/auth.php';
require_once '../includes/db.php';

// Handle Delete and Mark as Read
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id=?");
        $stmt->execute([$id]);
        $_SESSION['success_msg'] = 'Message deleted successfully!';
        header("Location: messages.php");
        exit;
    }
    
    if ($action == 'mark_read') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE messages SET is_read=1 WHERE id=?");
        $stmt->execute([$id]);
        header("Location: messages.php");
        exit;
    }
}

// Fetch all messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold mb-0">Inbox Messages</h3>
</div>

<div class="custom-card p-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-custom mb-0 table-hover align-middle">
            <thead style="background-color: rgba(255,255,255,0.02);">
                <tr>
                    <th class="px-4 py-3 text-muted fw-semibold">Status</th>
                    <th class="px-4 py-3 text-muted fw-semibold">Date</th>
                    <th class="px-4 py-3 text-muted fw-semibold">Sender</th>
                    <th class="px-4 py-3 text-muted fw-semibold">Subject</th>
                    <th class="px-4 py-3 text-muted fw-semibold text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($messages as $msg): ?>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); <?= $msg['is_read'] ? 'opacity: 0.7;' : 'font-weight: bold;' ?>">
                    <td class="px-4 py-3">
                        <?php if($msg['is_read']): ?>
                            <span class="badge bg-secondary">Read</span>
                        <?php else: ?>
                            <span class="badge bg-primary">New</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-white"><?= date('M d, Y h:i A', strtotime($msg['created_at'])) ?></td>
                    <td class="px-4 py-3 text-white">
                        <?= htmlspecialchars($msg['name']) ?><br>
                        <small class="text-muted fw-normal"><?= htmlspecialchars($msg['email']) ?></small>
                    </td>
                    <td class="px-4 py-3 text-white"><?= htmlspecialchars($msg['subject']) ?></td>
                    <td class="px-4 py-3">
                        <div class="d-flex justify-content-end gap-2 flex-nowrap">
                            <button class="btn btn-sm btn-outline-light view-btn" 
                                    data-name="<?= htmlspecialchars($msg['name']) ?>"
                                    data-email="<?= htmlspecialchars($msg['email']) ?>"
                                    data-date="<?= date('M d, Y h:i A', strtotime($msg['created_at'])) ?>"
                                    data-subject="<?= htmlspecialchars($msg['subject']) ?>"
                                    data-message="<?= htmlspecialchars($msg['message']) ?>"
                                    data-id="<?= $msg['id'] ?>"
                                    data-read="<?= $msg['is_read'] ?>"
                                    data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $msg['id'] ?>"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-<?= $msg['id'] ?>" method="POST" class="d-none">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($messages) == 0): ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">No messages yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title text-white">Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">From</label>
                        <h6 class="text-white mb-0" id="view_name"></h6>
                        <a href="#" id="view_email" class="text-primary small text-decoration-none"></a>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <label class="text-muted small d-block">Date Received</label>
                        <h6 class="text-white mb-0" id="view_date"></h6>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="text-muted small d-block">Subject</label>
                    <h5 class="text-white" id="view_subject"></h5>
                </div>
                
                <div class="p-4 rounded-3" style="background-color: var(--bg-color); border: 1px solid rgba(255,255,255,0.05);">
                    <p class="text-white mb-0" style="white-space: pre-wrap;" id="view_message"></p>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <form method="POST" id="markReadForm" class="d-none">
                    <input type="hidden" name="action" value="mark_read">
                    <input type="hidden" name="id" id="read_id">
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewBtns = document.querySelectorAll('.view-btn');
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('view_name').textContent = this.getAttribute('data-name');
            document.getElementById('view_email').textContent = this.getAttribute('data-email');
            document.getElementById('view_email').href = 'mailto:' + this.getAttribute('data-email');
            document.getElementById('view_date').textContent = this.getAttribute('data-date');
            document.getElementById('view_subject').textContent = this.getAttribute('data-subject');
            document.getElementById('view_message').textContent = this.getAttribute('data-message');
            
            const id = this.getAttribute('data-id');
            const isRead = this.getAttribute('data-read');
            
            // Mark as read if not already read
            if (isRead == '0') {
                document.getElementById('read_id').value = id;
                document.getElementById('markReadForm').submit();
            }
        });
    });

    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Delete Message?',
                text: "You won't be able to recover this message!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                background: 'var(--surface-color)',
                color: 'white'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        });
    });
});
</script>

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
