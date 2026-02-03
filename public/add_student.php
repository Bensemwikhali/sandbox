<?php
require_once "helpers/auth.php";
require_once "helpers/role.php";
require_auth();
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid request');
    }

     $name  = trim($_POST['name'] ?? '');
    $admNo = trim($_POST['adm_no'] ?? '');
    $grade = trim($_POST['grade'] ?? '');

    if ($name === '' || $admNo === '' || $grade === '') {
        die('All fields are required');
    }

    if (!preg_match('/^[A-Za-z0-9\/\-]+$/', $admNo)) {
        die('Invalid admission number');
    }

    $stmt = $conn->prepare(
        "INSERT INTO students (name, adm_no, grade) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $name, $admNo, $grade);
    $stmt->execute();

    $_SESSION['success'] = 'Student added successfully';
    header('Location: students.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student registration form</title>
</head>
<body>


    <h1>STUDENT REGISTRATION FORM</h1>
    <form action="process_student.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your full name"><br>

        <label for="adm_no">Admission number</label>
        <input type="text" id="adm_no"name="adm_no" placeholder="Enter your admission number"><br>

        <label for="grade">Grade</label>
        <input type="text"id=grade name="grade" placeholder="Enter your grade"><br>
        <button type="submit">Submit</button>





    </form>
</body>
</html>