<?php 
require_once 'includes/auth.php';
require_once '../includes/db.php';

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'add' || $action == 'edit') {
        $name = $_POST['name'];
        $percentage = (int)$_POST['percentage'];
        $icon = $_POST['icon'] ?? '';
        
        $imagePath = $_POST['existing_image'] ?? '';
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $imagePath = '';
        }
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = '../assets/images/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '_skill.' . $ext;
            $target = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = 'assets/images/uploads/' . $fileName;
            }
        }
        
        if ($action == 'add') {
            $stmt = $pdo->prepare("INSERT INTO skills (name, percentage, icon, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $percentage, $icon, $imagePath]);
        } else {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE skills SET name=?, percentage=?, icon=?, image=? WHERE id=?");
            $stmt->execute([$name, $percentage, $icon, $imagePath, $id]);
        }
        header("Location: skills");
        exit;
    }
    
    if ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id=?");
        $stmt->execute([$id]);
        header("Location: skills");
        exit;
    }
}

// Fetch all skills
$stmt = $pdo->query("SELECT * FROM skills ORDER BY percentage DESC");
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <h4 class="text-white fw-bold mb-0">Manage Skills</h4>
    <button class="btn btn-primary-custom btn-sm-lg" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus me-2"></i>Add Skill
    </button>
</div>

<div class="row g-3 g-md-4">
    <?php foreach($skills as $skill): ?>
    <div class="col-12 col-md-6 col-lg-4">
        <div class="custom-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-3">
                    <?php if(!empty($skill['image'])): ?>
                        <img src="../<?= htmlspecialchars($skill['image']) ?>" alt="<?= htmlspecialchars($skill['name']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    <?php else: ?>
                        <i class="<?= htmlspecialchars($skill['icon']) ?> fa-2x"></i>
                    <?php endif; ?>
                    <h5 class="mb-0 text-white"><?= htmlspecialchars($skill['name']) ?></h5>
                </div>
                <span class="text-muted small"><?= htmlspecialchars($skill['percentage']) ?>%</span>
            </div>
            <div class="progress-custom mb-4">
                <div class="progress-bar-custom" style="width: <?= htmlspecialchars($skill['percentage']) ?>%"></div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-auto">
                <button class="btn btn-sm btn-outline-light edit-btn" 
                        data-id="<?= $skill['id'] ?>"
                        data-name="<?= htmlspecialchars($skill['name']) ?>"
                        data-percentage="<?= htmlspecialchars($skill['percentage']) ?>"
                        data-icon="<?= htmlspecialchars($skill['icon']) ?>"
                        data-image="<?= htmlspecialchars($skill['image']) ?>"
                        data-bs-toggle="modal" data-bs-target="#editModal">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $skill['id'] ?>"><i class="fas fa-trash"></i></button>
                <form id="delete-form-<?= $skill['id'] ?>" method="POST" class="d-none">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $skill['id'] ?>">
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Add Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Skill Name (e.g. PHP)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Proficiency Percentage (0-100)</label>
                        <input type="number" name="percentage" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Skill Image</label>
                        <input type="file" name="image" class="form-control" accept="image/jpeg, image/png, image/svg+xml">
                        <small class="text-muted d-block mt-1">Upload a custom image/logo for the skill.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">OR FontAwesome Icon Class</label>
                        <input type="text" name="icon" class="form-control">
                        <small class="text-muted d-block mt-1">Leave blank if using an image.</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="existing_image" id="edit_existing_image">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Edit Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Skill Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Proficiency Percentage (0-100)</label>
                        <input type="number" name="percentage" id="edit_percentage" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Update Skill Image</label>
                        <input type="file" name="image" class="form-control" accept="image/jpeg, image/png, image/svg+xml">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image_skill">
                            <label class="form-check-label text-muted small" for="remove_image_skill">
                                Remove current image
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">OR FontAwesome Icon Class</label>
                        <input type="text" name="icon" id="edit_icon" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Update</button>
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
            document.getElementById('edit_name').value = this.getAttribute('data-name');
            document.getElementById('edit_percentage').value = this.getAttribute('data-percentage');
            document.getElementById('edit_icon').value = this.getAttribute('data-icon');
            document.getElementById('edit_existing_image').value = this.getAttribute('data-image');
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
