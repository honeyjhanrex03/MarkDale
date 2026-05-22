<?php require_once 'includes/header.php'; ?>
<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <h2 class="section-title">My Services</h2>
        <div class="row g-4 mt-4">
            <?php
            $stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($services) > 0):
            foreach($services as $service): 
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="custom-card p-5 h-100 d-flex flex-column text-center" style="border-radius: 20px; border: 1px solid rgba(255,255,255,0.03); background-color: #121218; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 75px; height: 75px; background-color: var(--surface-light); border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                            <?php if(!empty($service['image'])): ?>
                                <img src="assets/images/services/<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                            <?php elseif(!empty($service['icon'])): ?>
                                <?php if (filter_var($service['icon'], FILTER_VALIDATE_URL)): ?>
                                    <img src="<?= htmlspecialchars($service['icon']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                                <?php else: ?>
                                    <i class="<?= htmlspecialchars($service['icon']) ?> fs-2" style="color: #3b82f6;"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <h4 class="text-white fw-bold mb-3" style="letter-spacing: -0.5px;"><?= htmlspecialchars($service['name']) ?></h4>
                    <p class="text-muted flex-grow-1 mb-0" style="font-size: 0.95rem; line-height: 1.7;"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                </div>
            </div>
            <?php endforeach; else: ?>
                <div class="col-12 text-center py-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.05);">
                        <i class="fas fa-concierge-bell fa-2x text-muted"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-2">No Services Posted Yet</h4>
                    <p class="text-muted mb-0">Check back later for newly added services!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
