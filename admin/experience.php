<?php 
require_once 'includes/auth.php';
require_once '../includes/db.php';

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'add' || $action == 'edit') {
        $type = $_POST['type'];
        $year = $_POST['year'];
        $title = $_POST['title'];
        $company = $_POST['company'];
        $description = $_POST['description'] ?? '';
        
        if ($action == 'add') {
            $stmt = $pdo->prepare("INSERT INTO experience (type, year, title, company, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$type, $year, $title, $company, $description]);
        } else {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE experience SET type=?, year=?, title=?, company=?, description=? WHERE id=?");
            $stmt->execute([$type, $year, $title, $company, $description, $id]);
        }
        header("Location: experience");
        exit;
    }
    
    if ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM experience WHERE id=?");
        $stmt->execute([$id]);
        header("Location: experience");
        exit;
    }
}

// Fetch all experiences
$stmt = $pdo->query("SELECT * FROM experience ORDER BY type, year DESC");
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold mb-0">Manage Experience & Education</h3>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus me-2"></i>Add New
    </button>
</div>

<div class="custom-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom mb-0 table-hover align-middle">
            <thead style="background-color: rgba(255,255,255,0.02);">
                <tr>
                    <th class="px-4 py-3 text-muted fw-semibold">Type</th>
                    <th class="px-4 py-3 text-muted fw-semibold">Year</th>
                    <th class="px-4 py-3 text-muted fw-semibold">Title</th>
                    <th class="px-4 py-3 text-muted fw-semibold">Company/Institution</th>
                    <th class="px-4 py-3 text-muted fw-semibold text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($experiences as $exp): ?>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td class="px-4 py-3">
                        <?php if($exp['type'] == 'work'): ?>
                            <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-25 px-2 py-1">Work</span>
                        <?php elseif($exp['type'] == 'education'): ?>
                            <span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-25 px-2 py-1">Education</span>
                        <?php else: ?>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-2 py-1">Certification</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-white"><?= htmlspecialchars($exp['year']) ?></td>
                    <td class="px-4 py-3 text-white fw-medium"><?= htmlspecialchars($exp['title']) ?></td>
                    <td class="px-4 py-3 text-muted"><?= htmlspecialchars($exp['company']) ?></td>
                    <td class="px-4 py-3">
                        <div class="d-flex justify-content-end gap-2 flex-nowrap">
                            <button class="btn btn-sm btn-outline-light edit-btn" 
                                    data-id="<?= $exp['id'] ?>"
                                    data-type="<?= $exp['type'] ?>"
                                    data-year="<?= htmlspecialchars($exp['year']) ?>"
                                    data-title="<?= htmlspecialchars($exp['title']) ?>"
                                    data-company="<?= htmlspecialchars($exp['company']) ?>"
                                    data-description="<?= htmlspecialchars($exp['description']) ?>"
                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $exp['id'] ?>"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-<?= $exp['id'] ?>" method="POST" class="d-none">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $exp['id'] ?>">
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($experiences) == 0): ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">No experience entries found. Add one to get started!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Add New Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="work">Work Experience</option>
                            <option value="education">Education</option>
                            <option value="certification">Certification</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Year (e.g. 2022-2024 or 2024)</label>
                        <input type="text" name="year" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Title / Degree / Certificate</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Company / Institution</label>
                        <input type="text" name="company" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description (Optional for Education/Certs)</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Save Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Edit Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Type</label>
                        <select name="type" id="edit_type" class="form-select" required>
                            <option value="work">Work Experience</option>
                            <option value="education">Education</option>
                            <option value="certification">Certification</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Year</label>
                        <input type="text" name="year" id="edit_year" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Title / Degree / Certificate</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Company / Institution</label>
                        <input type="text" name="company" id="edit_company" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Update Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.getAttribute('data-id');
            document.getElementById('edit_type').value = this.getAttribute('data-type');
            document.getElementById('edit_year').value = this.getAttribute('data-year');
            document.getElementById('edit_title').value = this.getAttribute('data-title');
            document.getElementById('edit_company').value = this.getAttribute('data-company');
            document.getElementById('edit_description').value = this.getAttribute('data-description');
        });
    });
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
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

<?php require_once 'includes/footer.php'; ?>
