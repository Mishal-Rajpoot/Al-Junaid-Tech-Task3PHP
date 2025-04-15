<?php
session_start();
require_once '../config/db.php';

if (!$_SESSION['is_admin']) exit("Access denied.");

$id = $_GET['id'];
$stmt = $pdo->prepare("UPDATE blogs SET is_approved = 1 WHERE id = ?");
$stmt->execute([$id]);
header("Location: admin.php");
