<?php
session_start();
require_once '../config/db.php';
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: ../index.php");
    } else {
        echo "Invalid login credentials.";
    }
}
session_start();
session_regenerate_id(true); // Prevent session fixation
$_SESSION['user_id'] = $user['id'];
$_SESSION['is_admin'] = $user['is_admin'];
$_SESSION['user_name'] = $user['name'];

?>
