<?php
require_once "helpers/auth.php";
require_once "config/db.php";

require_auth();

$limit = 5;
$page = max((int)($_GET['page'] ?? 1), 1);
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $stmt = $conn->prepare(
        "SELECT COUNT(*) FROM students
         WHERE name LIKE ? OR adm_no LIKE ?"
    );
    $term = "%$search%";
    $stmt->bind_param("ss", $term, $term);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM students");
}

$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$totalPages = ceil($total / $limit);

if ($search !== '') {
    $stmt = $conn->prepare(
        "SELECT * FROM students
         WHERE name LIKE ? OR adm_no LIKE ?
         LIMIT ? OFFSET ?"
    );
    $stmt->bind_param("ssii", $term, $term, $limit, $offset);
} else {
    $stmt = $conn->prepare(
        "SELECT * FROM students
         LIMIT ? OFFSET ?"
    );
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
$search = $_GET['search'] ?? '';   
?>                                

<form method="GET">
    <input type="text" name="search"
           value="<?= htmlspecialchars($search) ?>"
           placeholder="Search student">
    <button type="submit">Search</button>
</form>

<table border="1">
<tr>
    <th>Name</th>
    <th>Admission No</th>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <th>Actions</th>
    <?php endif; ?>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['adm_no']) ?></td>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <td>
            <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="delete_student.php?id=<?= $row['id'] ?>">Delete</a>
        </td>
    <?php endif; ?>
</tr>
<?php endwhile; ?>
</table>

<div>
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
</div>
