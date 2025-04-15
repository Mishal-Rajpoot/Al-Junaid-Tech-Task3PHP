<?php
require_once '../config/db.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$is_admin = isset($_POST['is_admin']) ? (int)$_POST['is_admin'] : 0;

// Validate email uniqueness, etc.

$stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $email, $password, $is_admin]);

header("Location: ../login.html");
exit;
?>
