<?php
require_once "helpers/auth.php";
require_auth();

require_once "config/db.php";

$result = $conn->query("SELECT id, name, adm_no, grade FROM students");
$students = $result->fetch_all(mode: MYSQLI_ASSOC);
?>

<table border="1">
<tr>
    <th>Name</th>
    <th>Adm No</th>
    <th>Grade</th>
    <th>Action</th>
</tr>
<?php foreach ($students as $student): ?>
    <tr>
<td><?= $student['name'] ?></td>
<td><?= $student['adm_no'] ?></td>
<td><?= $student['grade'] ?></td>
<td>
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="edit_student.php?id=<?= $student['id'] ?>">Edit</a> |
      <a href="delete_student.php?id=<?= $student['id'] ?>"
         onclick="return confirm('Are you sure?')">Delete</a>
    <?php else: ?>
        view only
    <?php endif; ?>

</td>

    </tr>
<?php endforeach; ?>
</table>