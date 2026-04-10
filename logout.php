<?php
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
    setcookie('email', '', time() - 3600);
    header('Location : index.php');
    exit;
}
