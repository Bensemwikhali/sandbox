<?php
require_once "helpers/auth.php";
require_once "helpers/role.php";
require_once "config/db.php";
require_once "helpers/flash.php";

require_auth();
require_admin();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? 'user';

if (empty($username) || empty($password)) {
    set_flash('error', 'All fields are required');
    header("Location: add_user.php");
    exit;
}

if (!in_array($role, ['admin', 'user'])) {
    set_flash('error', 'Invalid role selected');
    header("Location: add_user.php");
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $username, $hash, $role);

if ($stmt->execute()) {
    set_flash('success', 'User created successfully');
    header("Location: dashboard.php");
} else {
    set_flash('error', 'Username already exists');
    header("Location: add_user.php");
}
exit;
