<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
require_once "helpers/flash.php";

$error = get_flash('error');
$success = get_flash('success');
?>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

    <h1>Login</h1>

    <form action="process_login.php" method="POST">
        username: <input type="text" name="username" required><br>
        password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>