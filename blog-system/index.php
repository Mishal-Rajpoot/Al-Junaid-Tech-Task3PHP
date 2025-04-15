<?php
session_start();
require_once 'config/db.php'; // Make sure this connects to MySQL using PDO

$search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

try {
    // Count total approved blog posts
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM blogs WHERE is_approved = 1 AND (title LIKE ? OR content LIKE ?)");
    $countStmt->execute(["%$search%", "%$search%"]);
    $totalPosts = $countStmt->fetchColumn();
    $totalPages = ceil($totalPosts / $limit);

    // Fetch approved blog posts
    $sql = "SELECT blogs.*, users.name 
            FROM blogs 
            JOIN users ON blogs.user_id = users.id 
            WHERE blogs.is_approved = 1 AND (blogs.title LIKE ? OR blogs.content LIKE ?) 
            ORDER BY blogs.created_at DESC 
            LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%", "%$search%"]);
    $blogs = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog Home</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div><a href="index.php"> Blog Management System</a></div>
    <div>
        <?php if (isset($_SESSION['user_name'])): ?>
            <span>Hello, <?= htmlspecialchars($_SESSION['user_name']) ?> | </span>
            <a href="auth/logout.php">Logout</a>
            <?php if ($_SESSION['is_admin']): ?>
                <a href="dashboard/admin.php">Admin Dashboard</a>
            <?php else: ?>
                <a href="blog/create.php">Create Blog</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.html">Login</a>
            <a href="register.html">Register</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <!-- Search Form -->
    <form method="GET" action="" class="search-form">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search blogs..."><br>
        <button class="button2" type="submit">Search</button>
       
    </form>

    <!-- Blog Posts -->
    <?php if (count($blogs) > 0): ?>
        <?php foreach ($blogs as $blog): ?>
            <div class="blog-card">
                <h3><?= htmlspecialchars($blog['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars(substr($blog['content'], 0, 200))) ?>...</p>
                <small>By <?= htmlspecialchars($blog['name']) ?> on <?= $blog['created_at'] ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No blog posts found.</p>
    <?php endif; ?>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($totalPages > 1): ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<!-- Blog Posts -->
<?php if (!empty($blogs) && count($blogs) > 0): ?>
    <?php foreach ($blogs as $blog): ?>
        <div class="blog-card">
            <h3><?= htmlspecialchars($blog['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars(substr($blog['content'], 0, 200))) ?>...</p>
            <small>By <?= htmlspecialchars($blog['name']) ?> on <?= $blog['created_at'] ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No blog posts found.</p>
<?php endif; ?>
