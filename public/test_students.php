<html>
    <head>
        <title>Students List</title>
    </head>
    <body>
        <h1>Students Information</h1>
        <link rel="stylesheet" href="assets/css/styles.css">
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Adm No</th>
                <th>Grade</th>
            </tr>
            <?php
            $students=[
                [    'name'=>'Ashley Okinyo',
                'age'=>20,
                'grade'=>13,
                'adm_no'=>3120,
            ],
            [
               'name'=>'Vera Auma',
                'age'=>21,
                'grade'=>14,
                'adm_no'=>3121, 
            ],
            [
                'name'=>'John Kamau',
                 'age'=>14,
                 'grade'=>7,
                 'adm_no'=>3122,
            ],
            [
                'name'=>'Mary Wafula',
                 'age'=>12,
                 'grade'=>6,
                 'adm_no'=>3123,
            ],
            ];
            foreach($students as $student){
                echo "<tr><td>".$student["name"]."</td><td>".$student["adm_no"]."</td><td>".$student["grade"]."</td></tr>";
            }
            ?>
        </table>
    </body>
</html>