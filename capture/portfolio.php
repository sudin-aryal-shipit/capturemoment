<?php
require 'db_config.php';
$stmt = $conn->query("SELECT * FROM portfolio");
$portfolios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portfolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>

        <a href="index.php">Home</a>
        <a href="gallery.php">Gallery</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="contact.php">Contact</a>
        <a href="admin_login.php">Admin Login</a>
    </nav>
    <div class="portfolio">
        <?php foreach ($portfolios as $portfolio): ?>
            <div class="portfolio-item">
                <h3><?php echo htmlspecialchars($portfolio['title']); ?></h3>
                <p><?php echo htmlspecialchars($portfolio['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
