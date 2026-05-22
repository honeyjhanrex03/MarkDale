<footer class="pt-5 pb-4 mt-5 border-top" style="border-color: rgba(255,255,255,0.05) !important; background-color: var(--surface-color);">
    <div class="container text-center">
        <!-- Logo -->
        <a href="./" class="d-inline-block mb-4 text-decoration-none">
            <img src="assets/images/logo.png" alt="MD Logo" style="height: 50px; width: auto; border-radius: 12px; filter: drop-shadow(0 0 15px rgba(139, 92, 246, 0.4));">
        </a>
        
        <!-- Links -->
        <div class="d-flex flex-wrap justify-content-center gap-3 gap-md-5 mb-4 footer-nav-links">
            <a href="about" class="text-muted text-decoration-none">About</a>
            <a href="projects" class="text-muted text-decoration-none">Projects</a>
            <a href="skills" class="text-muted text-decoration-none">Skills</a>
            <a href="experience" class="text-muted text-decoration-none">Experience</a>
            <a href="contact" class="text-muted text-decoration-none">Contact</a>
        </div>
        
        <!-- Socials -->
        <div class="d-flex justify-content-center gap-3 mb-2">
            <a href="https://www.facebook.com/markdalecabansag1" class="social-icon-footer" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <?php if(!empty($settings['linkedin'])): ?>
            <a href="<?= htmlspecialchars($settings['linkedin']) ?>" class="social-icon-footer" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            <?php endif; ?>
            <?php if(!empty($settings['github'])): ?>
            <a href="<?= htmlspecialchars($settings['github']) ?>" class="social-icon-footer" target="_blank"><i class="fab fa-github"></i></a>
            <?php endif; ?>
        </div>
        
        <hr style="border-color: rgba(255,255,255,0.1); margin: 2rem auto; width: 100%; max-width: 600px;">
        
        <p class="text-muted small mb-0">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['hero_name'] ?? 'Mark Dale D. Cabansag') ?>. All rights reserved.</p>
    </div>
</footer>

<style>
.footer-nav-links a { font-weight: 500; font-size: 0.95rem; transition: color 0.3s ease; }
.footer-nav-links a:hover { color: var(--primary-color) !important; }
.social-icon-footer {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background-color: rgba(255,255,255,0.03);
    color: var(--text-main);
    border-radius: 50%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.05);
}
.social-icon-footer:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
}
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Custom JS -->
<script src="assets/js/main.js?v=<?= filemtime('assets/js/main.js') ?>"></script>
<script>
// Back to top functionality
document.getElementById('backToTop').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
</body>
</html>
