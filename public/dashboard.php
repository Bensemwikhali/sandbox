<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="box">
    <h2>Dashboard</h2>

    <p>
        Welcome, <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong> 👋
    </p>

    <ul>
        <li><a href="test_students.php">View Students</a></li>
        <li><a href="add_student.php">Add Student</a></li>
    </ul>

    <br>

    <a href="logout.php">Logout</a>
</div>

</body>
</html>
