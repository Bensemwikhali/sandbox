<?php
require_once 'helpers/auth.php';
require_auth();
require_once 'config/db.php';

$search = '';
$params = [];
$types = '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    $sql = "SELECT * FROM students 
            WHERE name LIKE ? OR adm_no LIKE ?
            ORDER BY created_at DESC";
    $params = ["%$search%", "%$search%"];
    $types = "ss";
} else {
    $sql = "SELECT * FROM students ORDER BY created_at DESC";
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h2 class="mb-3">Students</h2>

    <!-- Search -->
    <form method="get" class="mb-3 d-flex gap-2">
        <input type="text" name="search" class="form-control"
               placeholder="Search by name or admission number"
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>

    <!-- Admin-only: Add Student -->
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="add_student.php" class="btn btn-primary mb-3">
            Add Student
        </a>
    <?php endif; ?>

    <!-- Students Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Admission No</th>
                <th>Name</th>
                <th>Grade</th>
                <th>Created At</th>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $i = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['adm_no']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <td>
                                <a href="edit_student.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_student.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this student?')">
                                   Delete
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= $_SESSION['role'] === 'admin' ? '6' : '5' ?>"
                        class="text-center">
                        No students found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
