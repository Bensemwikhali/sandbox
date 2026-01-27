<?php
require_once "config/db.php";

$id = $_GET["id"] ?? null;
if (!$id) die("Invalid student ID");

$stmt = $conn->prepare("SELECT name, adm_no, grade FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$student = $result->fetch_assoc();
if (!$student) die("Student not found");
?>

<!DOCTYPE html>
<html>
<body>

<h2>Edit Student</h2>

<form method="POST" action="update_student.php">
    <input type="hidden" name="id" value="<?= $id ?>">

    Name:
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>"><br>

    Adm No:
    <input type="text" name="adm_no" value="<?= htmlspecialchars($student['adm_no']) ?>"><br>

    Grade:
    <input type="number" name="grade" value="<?= htmlspecialchars($student['grade']) ?>"><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
