
    <?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin']) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO blogs (title, content, user_id) VALUES (?, ?, ?)");
    if ($stmt->execute([$title, $content, $user_id])) {
        echo "Blog post submitted successfully and awaiting admin approval.";
        echo '<br><a href="../index.php">Back</a>';
    } else {
        echo "Failed to create blog post.";
    }
}
?>


       

