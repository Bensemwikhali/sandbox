<?php
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name   = trim($_POST["username"]);
    $adm_no = trim($_POST["adm_no"]);
    $grade  = trim($_POST["grade"]);

    if (empty($name) || empty($adm_no) || empty($grade)) {
        die("All fields are required");
    }

    $sql = "INSERT INTO students (name, adm_no, grade) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssi", $name, $adm_no, $grade);

    if ($stmt->execute()) {
        header("Location: test_students.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
