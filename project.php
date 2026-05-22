<?php 
require_once 'includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id == 0) {
    header("Location: projects");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    header("Location: projects");
    exit;
}

$techs = explode(',', $project['tech_stack']);
$gallery = !empty($project['gallery_images']) ? explode(',', $project['gallery_images']) : [];
if (!empty($project['image'])) {
    array_unshift($gallery, $project['image']); // Add main image to start of gallery
}

// Filter out any images that were deleted from the server
$validGallery = [];
foreach($gallery as $img) {
    if (file_exists($img)) {
        $validGallery[] = $img;
    }
}
$gallery = $validGallery;

require_once 'includes/header.php'; 
?>

<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <div class="mb-4">
            <a href="projects" class="text-muted text-decoration-none border-bottom border-secondary pb-1"><i class="fas fa-arrow-left me-2"></i> Back to Projects</a>
        </div>
        
        <h1 class="display-4 fw-bold text-white mb-3"><?= htmlspecialchars($project['title']) ?></h1>
        
        <div class="row g-5 mt-3">
            <!-- Left Side: Carousel & Details -->
            <div class="col-lg-8">
                <?php if(count($gallery) > 1): ?>
                    <div id="projectCarousel" class="carousel slide rounded-4 overflow-hidden shadow-lg mb-5">
                        <div class="carousel-indicators">
                            <?php foreach($gallery as $index => $img): ?>
                                <button type="button" data-bs-target="#projectCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active"' : '' ?>></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner" style="background-color: #121218;">
                            <?php foreach($gallery as $index => $img): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100" style="height: 500px; object-fit: contain;" alt="Project Image">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#projectCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#projectCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                <?php elseif(count($gallery) == 1): ?>
                    <div class="rounded-4 shadow-lg w-100 mb-5 overflow-hidden" style="background-color: #121218;">
                        <img src="<?= htmlspecialchars($gallery[0]) ?>" class="img-fluid w-100" style="height: 500px; object-fit: contain;" alt="Project Image">
                    </div>
                <?php else: ?>
                    <div class="bg-secondary bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center w-100 mb-5" style="height: 500px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                <?php endif; ?>
                
                <h3 class="text-white fw-bold mb-4">Project Overview</h3>
                <div class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                    <?= nl2br(htmlspecialchars($project['description'])) ?>
                </div>
            </div>
            
            <!-- Right Side: Sidebar Info -->
            <div class="col-lg-4">
                <div class="custom-card p-4 sticky-top" style="top: 100px;">
                    <h5 class="text-white mb-4 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">Project Details</h5>
                    
                    <?php if(!empty($project['client'])): ?>
                    <div class="mb-4">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Client</small>
                        <span class="text-white fw-medium fs-5"><?= htmlspecialchars($project['client']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($project['project_date'])): ?>
                    <div class="mb-4">
                        <small class="text-muted d-block text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Date</small>
                        <span class="text-white fw-medium fs-5"><?= htmlspecialchars($project['project_date']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="mb-4">
                        <small class="text-muted d-block text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Technologies Used</small>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach($techs as $tech): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill"><?= htmlspecialchars(trim($tech)) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <?php if(!empty($project['link'])): ?>
                    <div class="mt-5 pt-3 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                        <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                            <span>View Live Project</span> <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
