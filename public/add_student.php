<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student registration form</title>
</head>
<body>
    <h1>STUDENT REGISTRATION FORM</h1>
    <form action="process_student.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your full name"><br>

        <label for="adm_no">Admission number</label>
        <input type="text" id="adm_no"name="adm_no" placeholder="Enter your admission number"><br>

        <label for="grade">Grade</label>
        <input type="text"id=grade name="grade" placeholder="Enter your grade"><br>
        <button type="submit">Submit</button>





    </form>
</body>
</html>