<?php
require_once "helpers/auth.php";
require_auth();

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
       <li><a href="students.php">View Students</a></li>
        <li><a href="add_student.php">Add Student</a></li>
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <li><a href="add_user.php">Add User</a></li>
<?php endif; ?>

    </ul>

    <br>

    <a href="logout.php">Logout</a>
</div>

</body>
</html>
