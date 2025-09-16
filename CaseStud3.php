<!DOCTYPE html>
<html>
<head>
    <title>Multiplication Table</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background: #fafafa;
}

h2 {
    text-align: center;
    margin-bottom: 15px;
}

table {
    border-collapse: collapse;
    margin: auto;
    background: white;
}

th, td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
    width: 40px;
    height: 40px;
}

th {
    background: #ccc;
}

.odd {
    background: yellow;
    font-weight: bold;
}

.input-box {
    text-align: center;
    margin-bottom: 15px;
}

input {
    padding: 4px;
    margin: 3px;
}

button {
    padding: 5px 10px;
    font-size: 14px;
    background: #444;
    color: white;
    border: none;
    cursor: pointer;
}

    </style>
</head>
<body>

<div class="input-box">
    <form method="post">
        <label>Enter Rows:</label>
        <input type="number" name="rows" required>
        <label>Enter Columns:</label>
        <input type="number" name="cols" required>
        <button type="submit">Generate</button>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rows = $_POST["rows"];
    $cols = $_POST["cols"];

    echo "<h2>Multiplication Table ($rows x $cols)</h2>";
    echo "<table>";
    
  
    echo "<tr><th>X</th>";
    for ($i = 1; $i <= $cols; $i++) {
        echo "<th>$i</th>";
    }
    echo "</tr>";

   
    for ($i = 1; $i <= $rows; $i++) {
        echo "<tr>";
        echo "<th>$i</th>"; 
        for ($j = 1; $j <= $cols; $j++) {
            $val = $i * $j;
            $class = ($val % 2 != 0) ? "odd" : "";
            echo "<td class='$class'>$val</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>

</body>
</html>
