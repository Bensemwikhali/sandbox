<?php
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name   = trim($_POST["username"]);
    $adm_no = trim($_POST["adm_no"]);
    $grade  = trim($_POST["grade"]);

    if (empty($name) || empty($adm_no) || empty($grade)) {
        die("All fields are required");
    }

     $stmt = $conn->prepare(
        "INSERT INTO students (name, adm_no, grade) VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $adm_no, $grade);
    $stmt->execute();

    header('Location: students.php');
    exit;
}
