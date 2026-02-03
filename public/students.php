<?php
session_start();
require_once "config/db.php";
require_once "helpers/auth.php";

/**
 * Search handling
 */
$search = $_GET['search'] ?? '';

$sql = "SELECT id, adm_no, name, grade, created_at FROM students";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " WHERE name LIKE ? OR adm_no LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types = "ss";
}

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

/**
 * Flash message ONLY after searching
 */
if (!empty($search) && $result->num_rows === 0) {
    $_SESSION['flash_error'] = "No students found";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
</head>
<body>

<h2>Students</h2>

<!-- Flash Message -->
<?php if (isset($_SESSION['flash_error'])): ?>
    <p style="color:red;">
        <?= $_SESSION['flash_error']; ?>
    </p>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<!-- Search Form -->
<form method="GET">
    <input type="text" name="search" placeholder="Search by name or adm no"
           value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<br>

<!-- Admin Only -->
<?php if (isAdmin()): ?>
    <a href="add_student.php">Add Student</a>
<?php endif; ?>

<br><br>

<table border="1" cellpadding="5">
    <tr>
        <th>#</th>
        <th>Admission No</th>
        <th>Name</th>
        <th>Grade</th>
        <th>Created At</th>
        <?php if (isAdmin()): ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>

<?php if ($result && $result->num_rows > 0): ?>
    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= htmlspecialchars($row['adm_no']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['grade']); ?></td>
            <td><?= htmlspecialchars($row['created_at']); ?></td>

            <?php if (isAdmin()): ?>
                <td>
                    <a href="edit_student.php?id=<?= $row['id']; ?>">Edit</a> |
                    <a href="delete_student.php?id=<?= $row['id']; ?>"
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="<?= isAdmin() ? 6 : 5; ?>">No students found</td>
    </tr>
<?php endif; ?>
</table>

</body>
</html>
