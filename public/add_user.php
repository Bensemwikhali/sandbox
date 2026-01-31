<?php
require_once "helpers/auth.php";
require_once "helpers/role.php";

require_auth();
require_admin();
?>

<!DOCTYPE html>
<html>
<body>

<h2>Add User</h2>

<form method="POST" action="process_add_user.php">
    Username:
    <input type="text" name="username"><br><br>

    Password:
    <input type="password" name="password"><br><br>

    Role:
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Create User</button>
</form>

<a href="dashboard.php">Back</a>

</body>
</html>
