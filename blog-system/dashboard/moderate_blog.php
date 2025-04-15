<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.html");
    exit;
}

$blog_id = (int)$_POST['blog_id'];
$action = $_POST['action'];

switch ($action) {
    case 'approve':
        $stmt = $pdo->prepare("UPDATE blogs SET is_approved = 1 WHERE id = ?");
        break;
    case 'disapprove':
        $stmt = $pdo->prepare("UPDATE blogs SET is_approved = 0 WHERE id = ?");
        break;
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
        break;
    default:
        die("Invalid action.");
}
$stmt->execute([$blog_id]);

header("Location: admin.php");
exit;
?>
