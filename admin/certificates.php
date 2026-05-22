<?php 
require_once 'includes/auth.php';
require_once '../includes/db.php';

// Ensure uploads directory exists
$uploadDir = '../assets/images/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'add' || $action == 'edit') {
        $title = $_POST['title'];
        $company = $_POST['company'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $keywords = $_POST['keywords'];
        $description = $_POST['description'];
        $type = 'certification';
        
        // Handle Image Upload
        $imagePath = $_POST['existing_image'] ?? '';
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $imagePath = '';
        }
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $ext;
            $target = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = 'assets/images/uploads/' . $fileName;
            }
        }
        
        if ($action == 'add') {
            $stmt = $pdo->prepare("INSERT INTO experience (type, title, company, month, year, keywords, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$type, $title, $company, $month, $year, $keywords, $description, $imagePath]);
        } else {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE experience SET title=?, company=?, month=?, year=?, keywords=?, description=?, image=? WHERE id=? AND type='certification'");
            $stmt->execute([$title, $company, $month, $year, $keywords, $description, $imagePath, $id]);
        }
        header("Location: certificates");
        exit;
    }
    
    if ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM experience WHERE id=? AND type='certification'");
        $stmt->execute([$id]);
        header("Location: certificates");
        exit;
    }
}

// Fetch certificates
$stmt = $pdo->query("SELECT * FROM experience WHERE type='certification' ORDER BY year DESC");
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold mb-0">Manage Certificates</h3>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus me-2"></i>Add Certificate
    </button>
</div>

<div class="row g-4">
    <?php foreach($certificates as $cert): ?>
    <div class="col-md-6 col-lg-4">
        <div class="custom-card p-4 h-100 d-flex flex-column">
            <?php if(!empty($cert['image'])): ?>
                <div class="text-center mb-3">
                    <img src="../<?= htmlspecialchars($cert['image']) ?>" alt="Certificate" class="img-fluid rounded" style="max-height: 150px; object-fit: contain;">
                </div>
            <?php endif; ?>
            <h5 class="text-white mb-2"><?= htmlspecialchars($cert['title']) ?></h5>
            <p class="text-muted small mb-2"><?= htmlspecialchars($cert['company']) ?> &bull; <?= htmlspecialchars($cert['month'] . ' ' . $cert['year']) ?></p>
            <?php if(!empty($cert['keywords'])): ?>
                <div class="mb-3 d-flex flex-wrap gap-1">
                    <?php 
                    $keys = explode(',', $cert['keywords']);
                    foreach($keys as $k): ?>
                        <span class="badge bg-secondary bg-opacity-25 text-light fw-normal"><?= htmlspecialchars(trim($k)) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <div class="mt-auto pt-3 border-top d-flex justify-content-end gap-2" style="border-color: rgba(255,255,255,0.05) !important;">
                <button class="btn btn-sm btn-outline-light edit-btn" 
                        data-id="<?= $cert['id'] ?>"
                        data-title="<?= htmlspecialchars($cert['title']) ?>"
                        data-company="<?= htmlspecialchars($cert['company']) ?>"
                        data-month="<?= htmlspecialchars($cert['month']) ?>"
                        data-year="<?= htmlspecialchars($cert['year']) ?>"
                        data-keywords="<?= htmlspecialchars($cert['keywords']) ?>"
                        data-description="<?= htmlspecialchars($cert['description']) ?>"
                        data-image="<?= htmlspecialchars($cert['image']) ?>"
                        data-bs-toggle="modal" data-bs-target="#editModal">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $cert['id'] ?>"><i class="fas fa-trash"></i></button>
                <form id="delete-form-<?= $cert['id'] ?>" method="POST" class="d-none">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $cert['id'] ?>">
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(count($certificates) == 0): ?>
    <div class="col-12 text-center py-5">
        <p class="text-muted">No certificates found. Add one to showcase your achievements!</p>
    </div>
    <?php endif; ?>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Add Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Title *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Issued By</label>
                            <input type="text" name="company" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Month</label>
                            <select name="month" class="form-select">
                                <option value="">Select Month</option>
                                <option value="January">January</option><option value="February">February</option>
                                <option value="March">March</option><option value="April">April</option>
                                <option value="May">May</option><option value="June">June</option>
                                <option value="July">July</option><option value="August">August</option>
                                <option value="September">September</option><option value="October">October</option>
                                <option value="November">November</option><option value="December">December</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Year</label>
                            <input type="text" name="year" class="form-control" placeholder="2026">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Certificate Image</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg, image/png">
                            <small class="text-muted d-block mt-1">JPG/PNG only, max 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Keywords (comma-separated)</label>
                            <input type="text" name="keywords" class="form-control" placeholder="e.g., .NET Framework, C#">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Add Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="existing_image" id="edit_existing_image">
                
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Edit Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Title *</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Issued By</label>
                            <input type="text" name="company" id="edit_company" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Month</label>
                            <select name="month" id="edit_month" class="form-select">
                                <option value="">Select Month</option>
                                <option value="January">January</option><option value="February">February</option>
                                <option value="March">March</option><option value="April">April</option>
                                <option value="May">May</option><option value="June">June</option>
                                <option value="July">July</option><option value="August">August</option>
                                <option value="September">September</option><option value="October">October</option>
                                <option value="November">November</option><option value="December">December</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Year</label>
                            <input type="text" name="year" id="edit_year" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Update Certificate Image</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg, image/png">
                            <small class="text-muted d-block mt-1">Leave empty to keep current image</small>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image_cert">
                                <label class="form-check-label text-muted small" for="remove_image_cert">
                                    Remove current image
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Keywords</label>
                            <input type="text" name="keywords" id="edit_keywords" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Update Certificate</button>
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
            document.getElementById('edit_title').value = this.getAttribute('data-title');
            document.getElementById('edit_company').value = this.getAttribute('data-company');
            document.getElementById('edit_month').value = this.getAttribute('data-month');
            document.getElementById('edit_year').value = this.getAttribute('data-year');
            document.getElementById('edit_keywords').value = this.getAttribute('data-keywords');
            document.getElementById('edit_description').value = this.getAttribute('data-description');
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
