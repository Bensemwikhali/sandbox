<?php
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id     = $_POST["id"];
    $name   = trim($_POST["name"]);
    $adm_no = trim($_POST["adm_no"]);
    $grade  = trim($_POST["grade"]);

    if (empty($name) || empty($adm_no) || empty($grade)) {
        die("All fields are required");
    }

    $stmt = $conn->prepare(
        "UPDATE students SET name = ?, adm_no = ?, grade = ? WHERE id = ?"
    );
    $stmt->bind_param("ssii", $name, $adm_no, $grade, $id);

    if ($stmt->execute()) {
        header("Location: test_students.php");
        exit;
    } else {
        echo "Update failed";
    }
}
