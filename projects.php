<?php require_once 'includes/header.php'; ?>
<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h2 class="section-title mb-0">Featured Projects</h2>
        </div>
        
        <div class="row g-4 mt-2">
            <?php
            $stmt = $pdo->query("SELECT * FROM projects");
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($projects) > 0):
            foreach($projects as $project): ?>
            <div class="col-md-6 col-lg-4">
                <a href="project?id=<?= $project['id'] ?>" class="text-decoration-none">
                    <div class="custom-card p-0 overflow-hidden d-flex flex-column h-100" style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="background-color: #121218; height: 200px;">
                            <img src="<?= htmlspecialchars($project['image']) ?>" alt="Project" class="img-fluid w-100" style="height: 100%; object-fit: contain;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="bg-secondary bg-opacity-10 w-100 align-items-center justify-content-center" style="height: 200px; display: none;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h5 class="text-white mb-2"><?= htmlspecialchars($project['title']) ?></h5>
                            <p class="text-muted small mb-4 flex-grow-1 text-truncate" style="max-height: 40px;"><?= htmlspecialchars($project['description']) ?></p>
                            <div class="d-flex gap-2 flex-wrap mt-auto">
                                <?php 
                                $techs = explode(',', $project['tech_stack']);
                                $displayTechs = array_slice($techs, 0, 3); // show only first 3 on card
                                foreach($displayTechs as $tech): ?>
                                    <span class="badge bg-secondary bg-opacity-25 text-light fw-normal"><?= htmlspecialchars(trim($tech)) ?></span>
                                <?php endforeach; 
                                if(count($techs) > 3): ?>
                                    <span class="badge bg-secondary bg-opacity-25 text-light fw-normal">+<?= count($techs)-3 ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; else: ?>
                <div class="col-12 text-center py-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.05);">
                        <i class="fas fa-folder-open fa-2x text-muted"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-2">No Projects Posted Yet</h4>
                    <p class="text-muted mb-0">Check back later for new featured projects!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
