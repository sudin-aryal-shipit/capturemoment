<?php
require 'db_config.php';
$stmt = $conn->query("SELECT * FROM gallery");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gallery</title>
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
    <div class="gallery">
        <?php foreach ($images as $image): ?>
            <img src="<?php echo $image['image_url']; ?>" alt="Gallery Image">
        <?php endforeach; ?>
    </div>
</body>
</html>
