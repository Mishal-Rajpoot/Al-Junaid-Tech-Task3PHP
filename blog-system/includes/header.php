<?php
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
} elseif (time() - $_SESSION['last_activity'] > 1800) { // 30 minutes
    session_unset();
    session_destroy();
    header("Location: ../login.html");
}
$_SESSION['last_activity'] = time();
