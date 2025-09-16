<?php

//Number 1
echo"Number 1: <br>";
$day = $_GET['Day'];

switch($day){
    case 1: echo "Monday";
    break;
    case 2 : echo "Tuesday";
    break;
    case 3 : echo "Wednesday";
    break;
    case 4 : echo "Thursday";
    break;
    case 5 : echo "Friday";
    break;
    case 6 : echo "Saturday";
    break;
    case 7 : echo "Sunday";
    break;
    default : echo "Invalid Number";
}


//Number 2
echo"<br><br>Number 2:";
$grade = $_GET['Grades'];

if($grade >= 90 && $grade <= 100){
    echo " <br> A";
}else if($grade >= 80 && $grade <= 89){
    echo " <br> B";
}else if($grade >= 70 && $grade <= 79){
    echo " <br> C";
}else if($grade >= 60 && $grade <= 69){
    echo " <br> D";
}else{
    echo " <br> F";
}


//Number 3
echo"<br><br>Number 3:<br>";
$num = $_GET['Num'];

if($num % 2 == 0){
    echo "Even";
}else{
    echo "Odd";
}

echo"<br><br>Number 4:<br>";
$year = $_GET['Year'];

if($year % 4 == 0){
    echo "$year is a Leap Year";
}else{
    echo "$year is not a Leap Year";
}

?>