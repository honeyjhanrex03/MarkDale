<?php
$is_local = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1', '::1']);

if ($is_local) {
    // Local credentials
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'marky_db';
} else {
    // Live hosted credentials (InfinityFree)
    $host = 'sql306.infinityfree.com';
    $user = 'if0_41993706';
    $pass = 'i6lh7l9JPOTB';
    $dbname = 'if0_41993706_marky_db';
}

try {
    if ($is_local) {
        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Create DB if not exists (Local only)
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
        $pdo->exec("USE `$dbname`");
    } else {
        // Connect directly to DB (Live)
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    // Create tables if they don't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        site_title VARCHAR(255) DEFAULT 'Mark Dale D. Cabansag',
        hero_title VARCHAR(255) DEFAULT 'INFORMATION SYSTEMS STUDENT',
        hero_name VARCHAR(255) DEFAULT 'MARK DALE D. CABANSAG',
        objective TEXT,
        email VARCHAR(255) DEFAULT 'markcabansag108@gmail.com',
        phone VARCHAR(50) DEFAULT '0993-740-0980',
        location VARCHAR(255) DEFAULT 'Purok 2b, Sto Nino, Carmen, Davao del Norte',
        linkedin VARCHAR(255) DEFAULT 'https://www.linkedin.com/in/mark-dale-cabansag-010105409/',
        github VARCHAR(255) DEFAULT ''
    )");
    
    // Auto-seeding disabled

    $pdo->exec("CREATE TABLE IF NOT EXISTS skills (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        percentage INT,
        icon VARCHAR(50),
        image VARCHAR(255) DEFAULT ''
    )");

    try {
        $pdo->exec("ALTER TABLE skills ADD COLUMN image VARCHAR(255) DEFAULT ''");
    } catch(PDOException $e) {}

    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        description TEXT,
        image VARCHAR(255),
        link VARCHAR(255),
        tech_stack VARCHAR(255),
        client VARCHAR(255) DEFAULT '',
        project_date VARCHAR(100) DEFAULT '',
        gallery_images TEXT DEFAULT ''
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS experience (
        id INT AUTO_INCREMENT PRIMARY KEY,
        year VARCHAR(50),
        month VARCHAR(50) DEFAULT '',
        title VARCHAR(255),
        company VARCHAR(255),
        description TEXT,
        image VARCHAR(255) DEFAULT '',
        keywords VARCHAR(255) DEFAULT '',
        type ENUM('work', 'education', 'certification') DEFAULT 'work'
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255)
    )");

    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $defaultPassword = password_hash('password123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO users (username, password) VALUES ('admin', '$defaultPassword')");
    }

    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        icon VARCHAR(255) DEFAULT '',
        image VARCHAR(255) DEFAULT '',
        description TEXT NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        is_read TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Auto-seeding disabled

    // Seeding logic for skills, experience, projects has been disabled 
    // so that deleted data does not automatically respawn.

    $pdo->exec("CREATE TABLE IF NOT EXISTS page_views (
        id INT AUTO_INCREMENT PRIMARY KEY,
        view_date DATE UNIQUE,
        views INT DEFAULT 1
    )");

    // Services seeding disabled

} catch(PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
