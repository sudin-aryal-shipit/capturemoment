<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload_image'])) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $conn->prepare("INSERT INTO gallery (image_url) VALUES (:image_url)");
            $stmt->bindParam(':image_url', $target);
            if ($stmt->execute()) {
                $message = "Image uploaded successfully!";
            } else {
                $message = "Failed to upload image.";
            }
        } else {
            $message = "Failed to move the uploaded file.";
        }
    }

    if (isset($_POST['add_portfolio'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $stmt = $conn->prepare("INSERT INTO portfolio (title, description) VALUES (:title, :description)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            $message = "Portfolio item added successfully!";
        } else {
            $message = "Failed to add portfolio item.";
        }
    }
}

// Fetch messages from the contact table
$stmt = $conn->query("SELECT * FROM contact ORDER BY id DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Admin Panel</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <h3>Upload Image to Gallery</h3>
        <input type="file" name="image" required>
        <button type="submit" name="upload_image">Upload</button>
    </form>

    <form method="post">
        <h3>Add to Portfolio</h3>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit" name="add_portfolio">Add</button>
    </form>

    <h3>Contact Messages</h3>
    <div class="contact-messages">
        <?php if (count($messages) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['id']); ?></td>
                            <td><?php echo htmlspecialchars($msg['name']); ?></td>
                            <td><?php echo htmlspecialchars($msg['email']); ?></td>
                            <td><?php echo htmlspecialchars($msg['message']); ?></td>
                            <td><?php echo htmlspecialchars($msg['created_at'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>

    <a href="logout.php">Logout</a>
</body>
</html>
