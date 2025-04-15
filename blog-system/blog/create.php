<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin']) {
    die("Access denied. Only registered users can create blog posts.");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Blog Post</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div><a href="index.php"> Blog Management System</a></div>
    <div>
<!DOCTYPE html>
<html>
<head>
    
    <link rel="stylesheet" href="../style.css">
</head>
<body class="center-form">
<!-- <h2>Create Blog Post</h2> -->
<div class="form-container">
<form action="store.php" method="POST">
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="content" placeholder="Write your post here..." rows="10" cols="50" required></textarea><br><br>
    <button class="button1" type="submit">Submit</button>
</form>
<!-- <p><a href="../index.php">← Back to Home</a></p> -->
</div>
</body>
</html>
