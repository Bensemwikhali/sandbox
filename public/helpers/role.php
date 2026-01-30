<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_admin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: dashboard.php");
        exit;
    }
}
