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
        $description = $_POST['description'];
        $tech_stack = $_POST['tech_stack'];
        $link = $_POST['link'];
        $client = $_POST['client'];
        $project_date = $_POST['project_date'];
        
        // Handle Main Image Upload
        $imagePath = $_POST['existing_image'] ?? '';
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $imagePath = '';
        }
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '_main.' . $ext;
            $target = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = 'assets/images/uploads/' . $fileName;
            }
        }

        // Handle Multiple Images Upload
        $galleryImages = $_POST['existing_gallery'] ?? '';
        if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
            $galleryArr = [];
            if(!empty($galleryImages)) $galleryArr = explode(',', $galleryImages);
            
            $fileCount = count($_FILES['gallery']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['gallery']['error'][$i] == 0) {
                    $ext = pathinfo($_FILES['gallery']['name'][$i], PATHINFO_EXTENSION);
                    $fileName = uniqid() . '_gallery_' . $i . '.' . $ext;
                    $target = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $target)) {
                        $galleryArr[] = 'assets/images/uploads/' . $fileName;
                    }
                }
            }
            $galleryImages = implode(',', $galleryArr);
        }
        
        if ($action == 'add') {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, link, tech_stack, client, project_date, gallery_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $imagePath, $link, $tech_stack, $client, $project_date, $galleryImages]);
        } else {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, image=?, link=?, tech_stack=?, client=?, project_date=?, gallery_images=? WHERE id=?");
            $stmt->execute([$title, $description, $imagePath, $link, $tech_stack, $client, $project_date, $galleryImages, $id]);
        }
        header("Location: projects");
        exit;
    }
    
    if ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id=?");
        $stmt->execute([$id]);
        header("Location: projects");
        exit;
    }
}

// Fetch all projects
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold mb-0">Manage Projects</h3>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus me-2"></i>Add Project
    </button>
</div>

<div class="row g-4">
    <?php foreach($projects as $project): ?>
    <div class="col-md-6 col-lg-4">
        <div class="custom-card p-4 h-100 d-flex flex-column" style="background-color: var(--surface-color);">
            <?php if(!empty($project['image'])): ?>
                <div class="text-center mb-3">
                    <img src="../<?= htmlspecialchars($project['image']) ?>" alt="Project" class="img-fluid rounded" style="max-height: 150px; object-fit: contain;">
                </div>
            <?php endif; ?>
            
            <h5 class="text-white mb-2"><?= htmlspecialchars($project['title']) ?></h5>
            <p class="text-muted small mb-3">
                <?= !empty($project['client']) ? htmlspecialchars($project['client']) : 'No Client' ?> 
                &bull; 
                <?= !empty($project['project_date']) ? htmlspecialchars($project['project_date']) : 'No Date' ?>
            </p>
            
            <div class="mt-auto pt-3 border-top d-flex justify-content-between" style="border-color: rgba(255,255,255,0.05) !important;">
                <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="btn btn-sm btn-outline-light"><i class="fas fa-link"></i> Link</a>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-light edit-btn" 
                            data-id="<?= $project['id'] ?>"
                            data-title="<?= htmlspecialchars($project['title']) ?>"
                            data-description="<?= htmlspecialchars($project['description']) ?>"
                            data-image="<?= htmlspecialchars($project['image']) ?>"
                            data-link="<?= htmlspecialchars($project['link']) ?>"
                            data-tech="<?= htmlspecialchars($project['tech_stack']) ?>"
                            data-client="<?= htmlspecialchars($project['client']) ?>"
                            data-date="<?= htmlspecialchars($project['project_date']) ?>"
                            data-gallery="<?= htmlspecialchars($project['gallery_images']) ?>"
                            data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $project['id'] ?>"><i class="fas fa-trash"></i></button>
                    <form id="delete-form-<?= $project['id'] ?>" method="POST" class="d-none">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $project['id'] ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(count($projects) == 0): ?>
    <div class="col-12 text-center py-5">
        <p class="text-muted">No projects found. Add one to showcase your work!</p>
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
                    <h5 class="modal-title text-white">Add Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Title *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description *</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tech Stack (comma separated)</label>
                            <input type="text" name="tech_stack" class="form-control" placeholder="e.g., HTML, CSS, JavaScript, PHP">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Link</label>
                            <input type="text" name="link" class="form-control" placeholder="https://">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Client</label>
                            <input type="text" name="client" class="form-control" placeholder="e.g., Dnsc Students (School Project)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Date</label>
                            <input type="text" name="project_date" class="form-control" placeholder="e.g., 06 January, 2023">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Main Project Image</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg, image/png">
                            <small class="text-muted d-block mt-1">JPG/PNG only, max 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Additional Images (Multiple)</label>
                            <input type="file" name="gallery[]" class="form-control" accept="image/jpeg, image/png" multiple>
                            <small class="text-muted d-block mt-1">Select multiple images for carousel</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Add Project</button>
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
                <input type="hidden" name="existing_gallery" id="edit_existing_gallery">
                
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-white">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Title *</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Description *</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tech Stack</label>
                            <input type="text" name="tech_stack" id="edit_tech" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Link</label>
                            <input type="text" name="link" id="edit_link" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Client</label>
                            <input type="text" name="client" id="edit_client" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Date</label>
                            <input type="text" name="project_date" id="edit_date" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Update Main Image</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg, image/png">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image_proj">
                                <label class="form-check-label text-muted small" for="remove_image_proj">
                                    Remove current main image
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Add to Gallery (Multiple)</label>
                            <input type="file" name="gallery[]" class="form-control" accept="image/jpeg, image/png" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Update Project</button>
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
            document.getElementById('edit_description').value = this.getAttribute('data-description');
            document.getElementById('edit_link').value = this.getAttribute('data-link');
            document.getElementById('edit_tech').value = this.getAttribute('data-tech');
            document.getElementById('edit_client').value = this.getAttribute('data-client');
            document.getElementById('edit_date').value = this.getAttribute('data-date');
            document.getElementById('edit_existing_image').value = this.getAttribute('data-image');
            document.getElementById('edit_existing_gallery').value = this.getAttribute('data-gallery');
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
