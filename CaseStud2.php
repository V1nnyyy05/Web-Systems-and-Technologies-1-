<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box {
            background: #fff;
            padding: 20px 30px;
            border: 3px solid #4CAF50;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
        }
    </style>
</head>
<body>
    <div class="box">
        <?php
        echo"GRADING SYSTEM<br>";
        $name = $_GET['name'];
        $grade = $_GET['Grades'];

        if ($grade <=100 && $grade >=95) {
            echo "$name, <br>Score: $grade <br>  Grade: 'A' <br> 'Outstanding Performance!'";
        } else if ($grade <=94 && $grade >=90) {
            echo "$name, <br>Score: $grade <br> Grade: 'B' <br> 'Great Job!'";
        } else if ($grade <=89 && $grade >=85) {
            echo "$name, <br>Score: $grade <br> Grade: 'C' <br> 'Good effort, keep it up!'";
        } else if ($grade <=84 && $grade >=75) {
            echo "$name, <br>Score: $grade <br> Grade: 'D' <br> 'Work harder next time'";
        } else if ($grade <= 74) {
            echo "$name, <br>Score: $grade <br> Grade: 'F' <br> 'You need to improve'";
        } else {
            echo "Better Luck Next Time!!";
        }
        ?>
    </div>
</body>
</html>
