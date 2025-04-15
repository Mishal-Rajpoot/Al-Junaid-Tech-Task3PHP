<?php
session_start();
require_once '../config/db.php';

if (!$_SESSION['is_admin']) exit("Access denied.");

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->execute([$id]);
header("Location: admin.php");
