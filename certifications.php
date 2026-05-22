<?php require_once 'includes/header.php'; ?>
<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <h2 class="section-title">Certifications and Trainings</h2>
        <div class="row g-4 mt-4">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM experience WHERE type='certification' ORDER BY year DESC");
            $stmt->execute();
            $certs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($certs) > 0) {
                foreach($certs as $cert): ?>
                    <div class="col-md-6">
                        <div class="custom-card p-0 overflow-hidden d-flex flex-column h-100">
                            <?php if(!empty($cert['image'])): ?>
                                <div class="bg-white text-center p-3" style="cursor: pointer;" onclick="openCertModal('<?= htmlspecialchars($cert['image']) ?>', '<?= htmlspecialchars(addslashes($cert['title'])) ?>')">
                                    <img src="<?= htmlspecialchars($cert['image']) ?>" alt="<?= htmlspecialchars($cert['title']) ?>" class="img-fluid rounded" style="max-height: 250px; object-fit: contain; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                            <?php else: ?>
                                <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-certificate fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <h4 class="text-white fw-bold mb-2"><?= htmlspecialchars($cert['title']) ?></h4>
                                <p class="text-muted small mb-3">
                                    <?= !empty($cert['month']) ? htmlspecialchars($cert['month']) . ' ' : '' ?><?= htmlspecialchars($cert['year']) ?>
                                </p>
                                <h6 class="text-white fw-semibold mb-3"><?= htmlspecialchars($cert['company']) ?></h6>
                                
                                <?php if(!empty($cert['description'])): ?>
                                    <p class="text-muted small mb-4 flex-grow-1"><?= nl2br(htmlspecialchars($cert['description'])) ?></p>
                                <?php endif; ?>
                                
                                <?php if(!empty($cert['keywords'])): ?>
                                    <div class="mt-auto d-flex flex-wrap gap-2 pt-3 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                                        <?php 
                                        $keys = explode(',', $cert['keywords']);
                                        foreach($keys as $k): ?>
                                            <span class="badge bg-dark border border-secondary text-light px-3 py-2 rounded-pill"><?= htmlspecialchars(trim($k)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; 
            } else { ?>
                <div class="col-12 text-center py-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.05);">
                        <i class="fas fa-certificate fa-2x text-muted"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-2">No Certificates Posted Yet</h4>
                    <p class="text-muted mb-0">Check back later for newly added certificates!</p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Certificate Image Modal -->
<div class="modal fade" id="certImageModal" tabindex="-1" aria-hidden="true" data-bs-theme="dark">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--surface-color); border: 1px solid rgba(255,255,255,0.1);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title text-white" id="certModalTitle">Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-white rounded-bottom">
                <img src="" id="certModalImg" class="img-fluid" alt="Certificate Full View">
            </div>
        </div>
    </div>
</div>

<script>
function openCertModal(imageSrc, title) {
    document.getElementById('certModalImg').src = imageSrc;
    document.getElementById('certModalTitle').textContent = title;
    var certModal = new bootstrap.Modal(document.getElementById('certImageModal'));
    certModal.show();
}
</script>
<?php require_once 'includes/footer.php'; ?>
