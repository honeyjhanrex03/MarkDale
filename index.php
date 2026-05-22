<?php require_once 'includes/header.php'; ?>

<section class="d-flex align-items-center position-relative overflow-hidden" style="min-height: calc(100vh - 100px);">
    
    <div class="container px-4 px-lg-5 position-relative z-1">
        <div class="row align-items-center">
            <!-- Left Content Block -->
            <div class="col-lg-6 mb-5 mb-lg-0 py-lg-5 order-2 order-lg-1 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-3 mb-4">
                    <div style="width: 50px; height: 3px; background-color: var(--primary-color);"></div>
                    <span class="text-uppercase fw-semibold tracking-wider text-muted" style="letter-spacing: 3px; font-size: 1rem;">
                        <?= htmlspecialchars($settings['hero_title'] ?? 'INFORMATION SYSTEMS STUDENT') ?>
                    </span>
                </div>
                
                <?php
                $hero_name = $settings['hero_name'] ?? 'MARK DALE D. CABANSAG';
                $name_parts = explode(' ', $hero_name);
                $last_name = array_pop($name_parts);
                $first_names = implode(' ', $name_parts);
                ?>
                <h1 class="display-3 fw-bold mb-4 text-white" style="line-height: 1.2; font-size: clamp(3.5rem, 5vw, 5rem);">
                    <?= htmlspecialchars($first_names) ?><br>
                    <span style="color: var(--primary-color);"><?= htmlspecialchars($last_name) ?></span>
                </h1>
                
                <p class="text-muted mb-5 pe-lg-5" style="font-size: 1.15rem; line-height: 1.9; max-width: 95%;">
                    <?= htmlspecialchars($settings['objective'] ?? 'Motivated and hardworking student seeking an opportunity to gain experience, improve skills, and contribute positively in a professional work environment.') ?>
                </p>
                
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start align-items-center">
                    <a href="projects" class="btn btn-primary-custom px-4 px-lg-5 py-3 d-flex align-items-center gap-2">
                        VIEW MY WORK <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="contact" class="btn btn-outline-custom px-4 px-lg-5 py-3 d-flex align-items-center gap-2">
                        CONTACT ME <i class="far fa-envelope ms-2"></i>
                    </a>
                </div>
                
                <div class="mt-4 pt-3 mt-lg-5 pt-lg-4 d-flex align-items-center justify-content-center justify-content-lg-start gap-3 gap-lg-4">
                    <span class="text-white fw-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">Follow Me</span>
                    <div class="d-flex gap-3 social-links-hero">
                        <a href="https://www.facebook.com/markdalecabansag1" class="text-white fs-5 fs-lg-4" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php if(!empty($settings['linkedin'])): ?>
                        <a href="<?= htmlspecialchars($settings['linkedin']) ?>" class="text-white fs-5 fs-lg-4" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <?php endif; ?>
                        <?php if(!empty($settings['github'])): ?>
                        <a href="<?= htmlspecialchars($settings['github']) ?>" class="text-white fs-5 fs-lg-4" target="_blank"><i class="fab fa-github"></i></a>
                        <?php endif; ?>
                        <?php if(!empty($settings['email'])): ?>
                        <a href="mailto:<?= htmlspecialchars($settings['email']) ?>" class="text-white fs-5 fs-lg-4" target="_blank"><i class="fas fa-envelope"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Right Image Block -->
            <div class="col-lg-6 text-center position-relative h-100 d-flex justify-content-center align-items-center mb-4 mb-lg-0 mt-4 mt-lg-0 order-1 order-lg-2">
                 <div class="position-relative d-inline-block" style="width: 75%; max-width: 450px;">
                     <!-- Exact Single Polygon Shape matching the Original Design 100% -->
                     <!-- We use a mathematically precise clip-path to create the slanted step and the fade exactly like the first picture -->
                     <div class="position-absolute" style="left: -30%; bottom: 0%; width: 150%; height: 90%; background: linear-gradient(to right, var(--primary-color) 40%, rgba(139, 92, 246, 0) 100%); clip-path: polygon(0% 100%, 20% 45%, 35% 45%, 55% 0%, 100% 0%, 70% 100%); z-index: 0;"></div>
                     
                     <!-- Decorative Dots -->
                     <img src="data:image/svg+xml,%3Csvg width='120' height='240' viewBox='0 0 120 240' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.25' fill-rule='evenodd'%3E%3Ccircle cx='10' cy='10' r='3'/%3E%3Ccircle cx='40' cy='10' r='3'/%3E%3Ccircle cx='70' cy='10' r='3'/%3E%3Ccircle cx='100' cy='10' r='3'/%3E%3Ccircle cx='10' cy='40' r='3'/%3E%3Ccircle cx='40' cy='40' r='3'/%3E%3Ccircle cx='70' cy='40' r='3'/%3E%3Ccircle cx='100' cy='40' r='3'/%3E%3Ccircle cx='10' cy='70' r='3'/%3E%3Ccircle cx='40' cy='70' r='3'/%3E%3Ccircle cx='70' cy='70' r='3'/%3E%3Ccircle cx='100' cy='70' r='3'/%3E%3Ccircle cx='10' cy='100' r='3'/%3E%3Ccircle cx='40' cy='100' r='3'/%3E%3Ccircle cx='70' cy='100' r='3'/%3E%3Ccircle cx='100' cy='100' r='3'/%3E%3Ccircle cx='10' cy='130' r='3'/%3E%3Ccircle cx='40' cy='130' r='3'/%3E%3Ccircle cx='70' cy='130' r='3'/%3E%3Ccircle cx='100' cy='130' r='3'/%3E%3Ccircle cx='10' cy='160' r='3'/%3E%3Ccircle cx='40' cy='160' r='3'/%3E%3Ccircle cx='70' cy='160' r='3'/%3E%3Ccircle cx='100' cy='160' r='3'/%3E%3Ccircle cx='10' cy='190' r='3'/%3E%3Ccircle cx='40' cy='190' r='3'/%3E%3Ccircle cx='70' cy='190' r='3'/%3E%3Ccircle cx='100' cy='190' r='3'/%3E%3Ccircle cx='10' cy='220' r='3'/%3E%3Ccircle cx='40' cy='220' r='3'/%3E%3Ccircle cx='70' cy='220' r='3'/%3E%3Ccircle cx='100' cy='220' r='3'/%3E%3C/g%3E%3C/svg%3E" alt="dots" style="position: absolute; right: -10%; top: 35%; z-index: -1;">
                     
                     <!-- Profile Image -->
                     <img src="assets/images/mark.jpg" alt="Profile" class="img-fluid position-relative w-100" style="z-index: 1; filter: drop-shadow(-10px 10px 30px rgba(0,0,0,0.6));">
                 </div>
            </div>
        </div>
    </div>
</section>

<style>
.social-links-hero a { transition: all 0.3s ease; opacity: 0.7; }
.social-links-hero a:hover { color: var(--primary-color) !important; transform: translateY(-4px); opacity: 1; }
</style>

<?php require_once 'includes/footer.php'; ?>
