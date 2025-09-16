<?php
$name       = "Ervin Hienz P. Cangco";
$title      = "BSIT Student";
$phone      = "09279634835";
$email      = "ervin.cangco@email.com";
$address    = "Cuyapo, Nueva Ecija";
$dob        = "15 May 2003";
$linkedin   = "linkedin.com/in/ervin-cangco";
$gitlab     = "gitlab.com/ervincangco";
$gender     = "Male";
$nationality= "Pilipino";

$school     = "Ongsiako Elementary School";
$school_year= "2011–2017";
$school_score="gpa: 88%";
$college    = "OLRA College Foundation";
$college_year="2017–2021";
$college_degree="Bachelor of Science in Information Technology";
$college_cgpa="GPA: 7.2";
$college_spec="Designing and Implementing System Software";

$exp_year   = "N/A";
$exp_title  = "N/A";



$skills = ["Visual Basic", "C, C++", "Java, HTML", "C#"];


$summary = "“As an IT student, my ambition is to continuously expand my knowledge of emerging technologies and develop practical solutions that address real-world challenges. I strive to build strong problem-solving and programming skills that will help me innovate in areas like software development, cybersecurity, and artificial intelligence. My ultimate goal is to contribute to creating impactful digital solutions that improve everyday life and drive technological growth.”";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $name; ?> - Resume</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      padding: 20px;
    }
    .resume {
      background: #fff;
      width: 800px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    .header {
      display: flex;
      align-items: center;
      background: #6d94b8ff;
      padding: 20px;
    }
    .header img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-right: 20px;
    }
    .header-content h1 {
      color: #000000ff;
      font-size: 28px;
      margin-bottom: 5px;
    }
    .header-content span {
      font-size: 16px;
      color: #555;
    }
    .header-details {
      background: #0077b6;
      color: white;
      padding: 15px;
      font-size: 14px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
    }
    .section {
      padding: 20px;
      border-bottom: 1px solid #ddd;
    }
    .section h2 {
      font-size: 20px;
      color: #0077b6;
      margin-bottom: 10px;
    }
    ul {
      margin-left: 20px;
    }
  </style>
</head>
<body>
  <div class="resume">

    <div class="header">
      <img src="idpic.jpg" alt="Profile Photo">
      <div class="header-content">
        <h1><?php echo $name; ?></h1>
        <span><?php echo $title; ?></span>
      </div>
    </div>

   
    <div class="header-details">
      <div><b>Phone:</b> <?php echo $phone; ?></div>
      <div><b>Address:</b> <?php echo $address; ?></div>
      <div><b>Email:</b> <?php echo $email; ?></div>
      <div><b>Date of Birth:</b> <?php echo $dob; ?></div>
      <div><b>LinkedIn:</b> <?php echo $linkedin; ?></div>
      <div><b>Gender:</b> <?php echo $gender; ?></div>
      <div><b>GitLab:</b> <?php echo $gitlab; ?></div>
      <div><b>Nationality:</b> <?php echo $nationality; ?></div>
    </div>

    <div class="section">
      <?php echo $summary; ?>
    </div>

    <div class="section">
      <h2>Education</h2>
   

      <b><?php echo $college_year; ?></b><br>
      <?php echo $college_degree; ?> - <?php echo $college; ?><br>
      <?php echo $college_cgpa; ?><br>
      Specialization: <?php echo $college_spec; ?>
    </div>

  
    <div class="section">
      <h2>Experience</h2>
      <b><?php echo $exp_year; ?></b><br>
      <?php echo $exp_title; ?><br>
   
    </div>

    <div class="section">
      <h2>Skills</h2>
      <ul>
        <?php
          foreach ($skills as $skill) {
            echo "<li>$skill</li>";
          }
        ?>
      </ul>
    </div>
  </div>
</body>
</html>
