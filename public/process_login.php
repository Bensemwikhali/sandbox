<?php
session_start();
require_once "config/db.php";
require_once "helpers/flash.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    set_flash('error', 'All fields are required');
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $user['role'];

    header("Location: dashboard.php");
    exit;
}

set_flash('error', 'Invalid username or password');
header("Location: login.php");
exit;
