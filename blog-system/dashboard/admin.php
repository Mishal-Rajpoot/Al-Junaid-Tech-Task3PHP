<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.html");
    exit;
}

// Fetch all blog posts
$stmt = $pdo->query("SELECT blogs.*, users.name FROM blogs JOIN users ON blogs.user_id = users.id ORDER BY blogs.created_at DESC");
$blogs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="navbar">
    <div><a href="../index.php">📝 Blog System</a></div>
    <div>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Admin Dashboard - Manage Blog Posts</h2>
    <?php foreach ($blogs as $blog): ?>
        <div class="blog-card">
            <h3><?= htmlspecialchars($blog['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars(substr($blog['content'], 0, 150))) ?>...</p>
            <small>By <?= htmlspecialchars($blog['name']) ?> | <?= $blog['created_at'] ?></small><br><br>

            <form method="POST" action="moderate_blog.php" style="display:inline;">
                <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                <input type="hidden" name="action" value="approve">
                <button type="submit">✅ Approve</button>
            </form>

            <form method="POST" action="moderate_blog.php" style="display:inline;">
                <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                <input type="hidden" name="action" value="disapprove">
                <button type="submit">🚫 Disapprove</button>
            </form>

            <form method="POST" action="moderate_blog.php" style="display:inline;">
                <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit">🗑️ Delete</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
