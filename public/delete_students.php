<?php
require_once "config/db.php";

$id = $_GET["id"] ?? null;
if (!$id) die("Invalid ID");

$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: test_students.php");
    exit;
} else {
    echo "Delete failed";
}
