<?php require_once 'includes/header.php'; ?>
<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <h2 class="section-title">My Skills</h2>
        <div class="row g-4 mt-4">
            <?php
            $stmt = $pdo->query("SELECT * FROM skills ORDER BY percentage DESC");
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($skills) > 0):
            foreach($skills as $skill): 
                // Extract color class from icon string (e.g., text-danger -> danger)
                $color = 'primary';
                if (preg_match('/text-([a-z]+)/', $skill['icon'], $matches)) {
                    $color = $matches[1];
                }
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="custom-card p-4 h-100 d-flex flex-column" style="border-radius: 16px;">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-4 bg-secondary bg-opacity-10" style="width: 60px; height: 60px; overflow: hidden;">
                            <?php if(!empty($skill['image'])): ?>
                                <img src="<?= htmlspecialchars($skill['image']) ?>" alt="<?= htmlspecialchars($skill['name']) ?>" style="width: 52px; height: 52px; object-fit: cover; border-radius: 12px;">
                            <?php else: ?>
                                <i class="<?= htmlspecialchars($skill['icon']) ?> fa-2x"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <h6 class="mb-0 text-white fw-bold"><?= htmlspecialchars($skill['name']) ?></h6>
                            <span class="text-<?= $color ?> fw-bold small"><?= htmlspecialchars($skill['percentage']) ?>%</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.05); overflow: visible;">
                            <div class="progress-bar bg-<?= $color ?> rounded-pill" role="progressbar" style="width: <?= htmlspecialchars($skill['percentage']) ?>%;" aria-valuenow="<?= htmlspecialchars($skill['percentage']) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <div class="col-12 text-center py-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.05);">
                        <i class="fas fa-star fa-2x text-muted"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-2">No Skills Posted Yet</h4>
                    <p class="text-muted mb-0">Check back later for newly added skills!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
