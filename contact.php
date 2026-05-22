<?php 
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        
        // --- BREVO API INTEGRATION ---
        $apiKey = 'YOUR_BREVO_API_KEY_HERE';
        
        $sendBrevoEmail = function($toEmail, $toName, $subject, $htmlContent) use ($apiKey) {
            $data = [
                "sender" => [
                    "name" => "Mark Dale Cabansag",
                    "email" => "markcabansag108@gmail.com"
                ],
                "to" => [
                    [
                        "email" => $toEmail,
                        "name" => $toName
                    ]
                ],
                "subject" => $subject,
                "htmlContent" => $htmlContent
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.brevo.com/v3/smtp/email");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "accept: application/json",
                "api-key: " . $apiKey,
                "content-type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            if(curl_error($ch)) {
                error_log('cURL error: ' . curl_error($ch));
            }
            curl_close($ch);
        };

        // 1. Professional HTML Email to the User
        $userHtml = "
        <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #000000; padding: 20px; text-align: center;'>
                <h2 style='color: white; margin: 0;'>Message Received!</h2>
            </div>
            <div style='padding: 30px;'>
                <p style='font-size: 16px;'>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p style='font-size: 16px; line-height: 1.6;'>Thank you for reaching out! I have successfully received your message regarding <em>\"" . htmlspecialchars($subject) . "\"</em>.</p>
                <p style='font-size: 16px; line-height: 1.6;'>I will review your inquiry and get back to you as soon as possible. In the meantime, feel free to check out more of my work on my portfolio.</p>
                <br>
                <p style='font-size: 16px; line-height: 1.6;'>Best regards,</p>
                <p style='font-size: 18px; font-weight: bold; margin-top: 5px; color: #000000;'>Mark Dale D. Cabansag</p>
                <p style='font-size: 14px; color: #666;'>Information Systems Student</p>
            </div>
            <div style='background-color: #f9f9f9; padding: 15px; text-align: center; font-size: 12px; color: #888;'>
                <p style='margin: 0;'>This is an automated email. Please do not reply directly to this message.</p>
            </div>
        </div>";
        $sendBrevoEmail($email, $name, "Thank you for contacting me - Mark Dale", $userHtml);

        // 2. Notification Email to Mark (Admin)
        $adminHtml = "
        <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #000000; padding: 20px; text-align: center;'>
                <h2 style='color: white; margin: 0;'>New Contact Form Submission</h2>
            </div>
            <div style='padding: 30px;'>
                <p style='font-size: 16px;'>Hello Mark,</p>
                <p style='font-size: 16px; line-height: 1.6;'>You have received a new message from your portfolio website.</p>
                <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd; font-weight: bold; width: 100px;'>Name:</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($name) . "</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd; font-weight: bold;'>Email:</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd; font-weight: bold;'>Subject:</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($subject) . "</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border: 1px solid #ddd; font-weight: bold; vertical-align: top;'>Message:</td>
                        <td style='padding: 10px; border: 1px solid #ddd;'>" . nl2br(htmlspecialchars($message)) . "</td>
                    </tr>
                </table>
                <br>
                <p style='font-size: 16px; text-align: center;'>
                    <a href='mailto:" . htmlspecialchars($email) . "' style='background-color: #000000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Reply to " . htmlspecialchars($name) . "</a>
                </p>
            </div>
        </div>";
        $sendBrevoEmail("markcabansag108@gmail.com", "Mark Dale", "New Message from " . htmlspecialchars($name), $adminHtml);

        $_SESSION['contact_success'] = true;
    } else {
        $_SESSION['contact_error'] = "All fields are required. Please complete the form before sending.";
    }
    header("Location: contact");
    exit;
}

require_once 'includes/header.php'; 
?>
<section class="py-5 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center mt-4">
            <!-- Left Column: Intro & Info -->
            <div class="col-lg-5 mb-5 mb-lg-0 pe-lg-5">
                <span class="text-uppercase tracking-wider fw-bold mb-2 d-block text-muted small" style="letter-spacing: 2px;">LET'S WORK TOGETHER</span>
                <h2 class="display-5 fw-bold text-white mb-4" style="line-height: 1.2;">Have a project<br>in mind?</h2>
                <p class="text-muted mb-5" style="line-height: 1.8; font-size: 1.1rem;">
                    I'm always open to discussing new projects, creative ideas or opportunities to be part of your visions.
                </p>
                
                <!-- Contact Info -->
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex gap-4 align-items-start">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: rgba(139, 92, 246, 0.1); color: var(--primary-color); font-size: 1.2rem;">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1 fw-semibold">Email</h6>
                            <a href="mailto:<?= htmlspecialchars($settings['email'] ?? '') ?>" class="text-muted text-decoration-none"><?= htmlspecialchars($settings['email'] ?? '') ?></a>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-4 align-items-start">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: rgba(139, 92, 246, 0.1); color: var(--primary-color); font-size: 1.2rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1 fw-semibold">Phone</h6>
                            <p class="text-muted mb-0"><?= htmlspecialchars($settings['phone'] ?? '') ?></p>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-4 align-items-start">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: rgba(139, 92, 246, 0.1); color: var(--primary-color); font-size: 1.2rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1 fw-semibold">Location</h6>
                            <p class="text-muted mb-0"><?= htmlspecialchars($settings['location'] ?? '') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: The Form -->
            <div class="col-lg-7">
                <div class="custom-card border-0" style="padding: 40px; background-color: var(--surface-color); border-top: 4px solid var(--primary-color) !important;">
                    <form method="POST" action="" id="contactForm">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-white small fw-semibold">Your Name</label>
                                <input type="text" name="name" class="form-control px-4 py-3 bg-transparent text-white" placeholder="John Doe" required style="border-color: rgba(255,255,255,0.1) !important; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white small fw-semibold">Your Email</label>
                                <input type="email" name="email" class="form-control px-4 py-3 bg-transparent text-white" placeholder="john@example.com" required style="border-color: rgba(255,255,255,0.1) !important; border-radius: 8px;">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-white small fw-semibold">Subject</label>
                                <input type="text" name="subject" class="form-control px-4 py-3 bg-transparent text-white" placeholder="How can I help you?" required style="border-color: rgba(255,255,255,0.1) !important; border-radius: 8px;">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-white small fw-semibold">Your Message</label>
                                <textarea name="message" class="form-control px-4 py-3 bg-transparent text-white" rows="5" placeholder="Write your message here..." required style="border-color: rgba(255,255,255,0.1) !important; border-radius: 8px;"></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold" style="letter-spacing: 1px;">SEND MESSAGE <i class="fas fa-paper-plane ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Enhance form focus states */
#contactForm .form-control:focus {
    background-color: rgba(139, 92, 246, 0.05) !important;
    border-color: var(--primary-color) !important;
    box-shadow: none !important;
}
#contactForm .form-control::placeholder {
    color: rgba(255,255,255,0.3);
}
</style>

<?php if(isset($_SESSION['contact_success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Message Sent!',
        text: 'Thank you for contacting me. I will get back to you soon.',
        confirmButtonColor: 'var(--primary-color)',
        background: 'var(--surface-color)',
        color: 'white'
    });
});
</script>
<?php unset($_SESSION['contact_success']); endif; ?>

<?php if(isset($_SESSION['contact_error'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Missing Fields!',
        text: '<?= htmlspecialchars($_SESSION['contact_error'], ENT_QUOTES) ?>',
        confirmButtonColor: 'var(--primary-color)',
        background: 'var(--surface-color)',
        color: 'white'
    });
});
</script>
<?php unset($_SESSION['contact_error']); endif; ?>

<?php require_once 'includes/footer.php'; ?>
