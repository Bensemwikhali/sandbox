<?php
require_once "helpers/auth.php";
require_once "config/db.php";

require_auth();

$limit  = 5;
$page   = max((int)($_GET['page'] ?? 1), 1);
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');
$term   = "%$search%";

/* ================= COUNT QUERY ================= */

if ($_SESSION['role'] === 'admin') {

    if ($search !== '') {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) FROM students
             WHERE name LIKE ? OR adm_no LIKE ?"
        );
        $stmt->bind_param("ss", $term, $term);
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM students");
    }

} else {

    if ($search !== '') {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) FROM students
             WHERE user_id = ?
             AND (name LIKE ? OR adm_no LIKE ?)"
        );
        $stmt->bind_param("iss", $_SESSION['user_id'], $term, $term);
    } else {
        $stmt = $conn->prepare(
            "SELECT COUNT(*) FROM students WHERE user_id = ?"
        );
        $stmt->bind_param("i", $_SESSION['user_id']);
    }
}

$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$totalPages = ceil($total / $limit);

/* ================= FETCH DATA ================= */

if ($_SESSION['role'] === 'admin') {

    if ($search !== '') {
        $stmt = $conn->prepare(
            "SELECT * FROM students
             WHERE name LIKE ? OR adm_no LIKE ?
             ORDER BY created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->bind_param("ssii", $term, $term, $limit, $offset);
    } else {
        $stmt = $conn->prepare(
            "SELECT * FROM students
             ORDER BY created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->bind_param("ii", $limit, $offset);
    }

} else {

    if ($search !== '') {
        $stmt = $conn->prepare(
            "SELECT * FROM students
             WHERE user_id = ?
             AND (name LIKE ? OR adm_no LIKE ?)
             ORDER BY created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->bind_param(
            "issii",
            $_SESSION['user_id'],
            $term,
            $term,
            $limit,
            $offset
        );
    } else {
        $stmt = $conn->prepare(
            "SELECT * FROM students
             WHERE user_id = ?
             ORDER BY created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->bind_param("iii", $_SESSION['user_id'], $limit, $offset);
    }
}

$stmt->execute();
$result = $stmt->get_result();
?>
<form method="GET">
    <input type="text" name="search"
           value="<?= htmlspecialchars($search) ?>"
           placeholder="Search by name or adm no">
    <button type="submit">Search</button>
</form>

<table border="1" cellpadding="8">
    <tr>
        <th>Name</th>
        <th>Admission No</th>
        <th>Grade</th>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['adm_no']) ?></td>
            <td><?= htmlspecialchars($row['grade']) ?></td>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <td>
                    <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete_student.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Delete this student?')">
                       Delete
                    </a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Pagination -->
<div style="margin-top:10px;">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
</div>

