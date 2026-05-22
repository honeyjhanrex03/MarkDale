<?php 
require_once 'includes/auth.php';
require_once '../includes/db.php';

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'add' || $action == 'edit') {
        $name = $_POST['name'];
        $icon = $_POST['icon'];
        $description = $_POST['description'];
        $image = '';
        
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'svg', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $new_filename = uniqid() . '.' . $ext;
                $upload_path = '../assets/images/services/' . $new_filename;
                // create directory if it doesn't exist
                if (!is_dir('../assets/images/services/')) {
                    mkdir('../assets/images/services/', 0777, true);
                }
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image = $new_filename;
                }
            }
        }
        
        if ($action == 'add') {
            $stmt = $pdo->prepare("INSERT INTO services (name, icon, image, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $icon, $image, $description]);
        } else {
            $id = $_POST['id'];
            if ($image != '') {
                $stmt = $pdo->prepare("UPDATE services SET name=?, icon=?, image=?, description=? WHERE id=?");
                $stmt->execute([$name, $icon, $image, $description, $id]);
            } elseif (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
                $stmt = $pdo->prepare("UPDATE services SET name=?, icon=?, image='', description=? WHERE id=?");
                $stmt->execute([$name, $icon, $description, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE services SET name=?, icon=?, description=? WHERE id=?");
                $stmt->execute([$name, $icon, $description, $id]);
            }
        }
        $_SESSION['success_msg'] = $action == 'add' ? 'Service added successfully!' : 'Service updated successfully!';
        header("Location: services.php");
        exit;
    }
    
    if ($action == 'delete') {
        $id = $_POST['id'];
        
        // Fetch image to delete
        $stmt = $pdo->prepare("SELECT image FROM services WHERE id=?");
        $stmt->execute([$id]);
        $service = $stmt->fetch();
        if ($service && !empty($service['image'])) {
            $img_path = '../assets/images/services/' . $service['image'];
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }
        
        $stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
        $stmt->execute([$id]);
        $_SESSION['success_msg'] = 'Service deleted successfully!';
        header("Location: services.php");
        exit;
    }
}

// Fetch all services
$stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold mb-0">Manage Services</h3>
</div>

<div class="custom-card p-4 mb-5">
    <h5 class="text-white mb-4">Add Service</h5>
    <form action="services.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="row">
            <!-- Service Name -->
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small">Service Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <!-- Icon Text/Class -->
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small">Icon (Font Awesome Class or Image URL)</label>
                <input type="text" name="icon" class="form-control" placeholder="e.g., fas fa-code or https://example.com/icon.png">
                <small class="text-muted d-block mt-1">Example: fas fa-code, fas fa-paint-brush, or image URL</small>
            </div>

            <!-- File Upload -->
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small">Or Upload Icon Image</label>
                <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/svg+xml, image/gif">
                <small class="text-muted d-block mt-1">PNG, JPG, SVG, or GIF (max 2MB)</small>
            </div>

            <!-- Description -->
            <div class="col-12 mb-3">
                <label class="form-label text-muted small">Description *</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary-custom px-4 mt-2">Add Service</button>
    </form>
</div>

<!-- List Services -->
<div class="row g-4">
    <?php foreach($services as $service): ?>
    <div class="col-md-6 col-lg-4">
        <div class="custom-card p-4 h-100">
            <div class="d-flex flex-column mb-3 text-center">
                <?php if(!empty($service['image'])): ?>
                    <img src="../assets/images/services/<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="img-fluid mb-3 mx-auto" style="max-height: 60px;">
                <?php elseif(!empty($service['icon'])): ?>
                    <?php if (filter_var($service['icon'], FILTER_VALIDATE_URL)): ?>
                        <img src="<?= htmlspecialchars($service['icon']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="img-fluid mb-3 mx-auto" style="max-height: 60px;">
                    <?php else: ?>
                        <i class="<?= htmlspecialchars($service['icon']) ?> fa-3x mb-3 text-primary mx-auto"></i>
                    <?php endif; ?>
                <?php endif; ?>
                <h5 class="mb-2 text-white"><?= htmlspecialchars($service['name']) ?></h5>
                <p class="text-muted small text-start"><?= htmlspecialchars($service['description']) ?></p>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-auto border-top pt-3 border-secondary border-opacity-25">
                <button class="btn btn-sm btn-outline-light edit-btn" 
                        data-id="<?= $service['id'] ?>"
                        data-name="<?= htmlspecialchars($service['name']) ?>"
                        data-icon="<?= htmlspecialchars($service['icon']) ?>"
                        data-description="<?= htmlspecialchars($service['description']) ?>"
                        data-bs-toggle="modal" data-bs-target="#editModal">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $service['id'] ?>"><i class="fas fa-trash"></i> Delete</button>
                <form id="delete-form-<?= $service['id'] ?>" method="POST" class="d-none">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Service Name *</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Icon (Font Awesome Class or Image URL)</label>
                        <input type="text" name="icon" id="edit_icon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Or Upload New Icon Image (Leave empty to keep current)</label>
                        <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/svg+xml, image/gif">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image_service">
                            <label class="form-check-label text-muted small" for="remove_image_service">
                                Remove current image
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description *</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Update Service</button>
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
            document.getElementById('edit_icon').value = this.getAttribute('data-icon');
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
