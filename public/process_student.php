<?php
require_once "config/db.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $errors = [];

    $username = trim($_POST["username"] ?? "");
    $adm_no   = trim($_POST["adm_no"] ?? "");
    $grade    = trim($_POST["grade"] ?? "");

    // Validation
    if (empty($username)) {
        $errors[] = "Student name is required";
    }

    if (empty($adm_no) || !is_numeric($adm_no)) {
        $errors[] = "Admission number must be numeric";
    }

    if (empty($grade) || $grade < 1 || $grade > 12) {
        $errors[] = "Grade must be between 1 and 12";
    }

    // Output
    if (!empty($errors)) {
        echo "<h3>Errors:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<a href='add_student.php'>Go back</a>";
    } else {
        echo "<h3>Student Registered Successfully</h3>";
        echo "Name: $username <br>";
        echo "Admission No: $adm_no <br>";
        echo "Grade: $grade <br>";
    }
}
?>