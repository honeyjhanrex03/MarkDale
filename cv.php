<?php 
require_once 'includes/db.php';
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_title'] ?? 'Portfolio') ?> - CV</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    
    <style>
        body, html { 
            margin: 0; 
            padding: 0; 
            height: 100%; 
            overflow: hidden; 
            background-color: #333;
        }
        iframe { 
            width: 100%; 
            height: 100%; 
            border: none; 
        }
    </style>
</head>
<body>
    <iframe src="resume/CABANSAG_CV123.pdf?v=<?= filemtime('resume/CABANSAG_CV123.pdf') ?>"></iframe>
</body>
</html>
