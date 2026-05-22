<?php require_once 'includes/header.php'; ?>
<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="section-title">Education</h2>
                <div class="timeline mt-5">
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM experience WHERE type='education' ORDER BY year DESC");
                    $stmt->execute();
                    $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(count($educations) == 0) {
                        echo '<div class="col-12 text-center py-5"><div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.05);"><i class="fas fa-graduation-cap fa-2x text-muted"></i></div><h4 class="text-white fw-bold mb-2">No Education Posted Yet</h4><p class="text-muted mb-0">Check back later for updates!</p></div>';
                    } else {
                        foreach($educations as $edu): ?>
                            <div class="timeline-item">
                                <div class="timeline-date"><?= htmlspecialchars($edu['year']) ?></div>
                                <h5 class="text-white mb-1"><?= htmlspecialchars($edu['title']) ?></h5>
                                <h6 class="text-muted mb-0"><?= htmlspecialchars($edu['company']) ?></h6>
                                <?php if(!empty($edu['description'])): ?>
                                <div class="text-muted small mt-2"><?= nl2br(htmlspecialchars($edu['description'])) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; 
                    } ?>
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="section-title">Experience</h2>
                <div class="timeline mt-5">
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM experience WHERE type='work' ORDER BY year DESC");
                    $stmt->execute();
                    $experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(count($experiences) == 0) {
                        echo '<div class="col-12 text-center py-5"><div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.05);"><i class="fas fa-briefcase fa-2x text-muted"></i></div><h4 class="text-white fw-bold mb-2">No Experience Posted Yet</h4><p class="text-muted mb-0">Check back later for updates!</p></div>';
                    } else {
                        foreach($experiences as $exp): ?>
                            <div class="timeline-item">
                                <div class="timeline-date"><?= htmlspecialchars($exp['year']) ?></div>
                                <h5 class="text-white mb-1"><?= htmlspecialchars($exp['title']) ?></h5>
                                <h6 class="text-muted mb-3"><?= htmlspecialchars($exp['company']) ?></h6>
                                <div class="text-muted small"><?= nl2br(htmlspecialchars($exp['description'])) ?></div>
                            </div>
                        <?php endforeach; 
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
