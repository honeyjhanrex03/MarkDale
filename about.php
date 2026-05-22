<?php require_once 'includes/header.php'; ?>
<section class="py-5 mt-5 min-vh-100">
    <div class="container">
        <h2 class="section-title">About Me</h2>
        <div class="row mt-5 g-4 align-items-stretch">
            <div class="col-lg-8">
                <div class="custom-card h-100">
                    <div class="row align-items-center mb-5">
                        <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                            <img src="assets/images/mark.jpg" alt="<?= htmlspecialchars($settings['hero_name'] ?? 'Mark Dale D. Cabansag') ?>" class="img-fluid rounded-4 shadow" style="max-height: 250px; object-fit: cover; border: 3px solid rgba(255,255,255,0.05);">
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-white fw-bold mb-1"><?= htmlspecialchars($settings['hero_name'] ?? 'MARK DALE D. CABANSAG') ?></h3>
                            <h6 class="mb-3 fw-semibold" style="color: var(--primary-color) !important;">BS Information Systems - 2nd Year <span class="text-white mx-2 opacity-50">|</span> Davao del Norte State College</h6>
                            <p class="text-muted fs-5 mb-0" style="line-height: 1.9;">
                                <?= nl2br(htmlspecialchars($settings['objective'] ?? 'I am an Information Systems student with a passion for developing innovative and efficient solutions.')) ?>
                            </p>
                        </div>
                    </div>
                    <div class="row g-4 mt-2 border-top pt-4" style="border-color: rgba(255,255,255,0.05) !important;">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--primary-color);">
                                    <i class="fas fa-map-marker-alt fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold">Location</h6>
                                    <p class="mb-0 text-muted small"><?= htmlspecialchars($settings['location'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--primary-color);">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold">Email</h6>
                                    <p class="mb-0 text-muted small"><?= htmlspecialchars($settings['email'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--primary-color);">
                                    <i class="fas fa-graduation-cap fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold">Degree</h6>
                                    <p class="mb-0 text-muted small">BS Information Systems</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--primary-color);">
                                    <i class="fas fa-phone fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold">Phone</h6>
                                    <p class="mb-0 text-muted small"><?= htmlspecialchars($settings['phone'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--primary-color);">
                                    <i class="fas fa-calendar-day fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold">Birthday</h6>
                                    <p class="mb-0 text-muted small">March 16, 2006</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: var(--primary-color);">
                                    <i class="fas fa-calendar-alt fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold">Age</h6>
                                    <?php
                                        $birthdate = new DateTime('2006-03-16');
                                        $today = new DateTime('today');
                                        $age = $birthdate->diff($today)->y;
                                    ?>
                                    <p class="mb-0 text-muted small"><?= $age ?> Years Old</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="custom-card text-center h-100 d-flex flex-column justify-content-center py-5">
                    <div class="bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-4" style="width: 60px; height: 60px; color: var(--primary-color);">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="fw-bold mb-5 text-white">References</h3>
                    
                    <div class="text-center mb-5 pb-3 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                        <h5 class="text-white fw-bold mb-2">Kholsom C. Argente</h5>
                        <p class="text-muted small mb-1">Human Resource Officer</p>
                        <p class="text-muted small mb-3">Maria Clara Resort and Restaurant</p>
                        <p class="text-primary fw-bold mb-0" style="color: var(--primary-color) !important;">09327016809</p>
                    </div>
                    
                    <div class="text-center">
                        <h5 class="text-white fw-bold mb-2">Mark P. Mallari</h5>
                        <p class="text-muted small mb-1">General Manager</p>
                        <p class="text-muted small mb-3">Maria Clara Resort and Restaurant</p>
                        <p class="text-primary fw-bold mb-0" style="color: var(--primary-color) !important;">09985987109</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
