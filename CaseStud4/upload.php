<?php
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";

    // Create folder if not exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["myfile"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;

    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // File exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // File size limit (2MB)
    if ($_FILES["myfile"]["size"] > 2 * 1024 * 1024) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allowed types
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($fileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF are allowed.<br>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
            echo "The file <b>" . htmlspecialchars($file_name) . "</b> has been uploaded.<br>";
            echo "<img src='" . $target_file . "' width='200'>";
        } else {
            echo "Error uploading file.";
        }
    }
}


if (isset($_POST['submit'])) {
    // Handle uploaded image
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = basename($_FILES["myfile"]["name"]);
    $targetFile = $uploadDir . $fileName;
    move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetFile);

    // Collect form data
    $data = $_POST;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submitted Bio-Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            background: #f4f6f9;
            color: #222;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            text-decoration: underline;
            margin-bottom: 20px;
        }
        .photo {
            text-align: right;
            margin-bottom: 15px;
        }
        .photo img {
            width: 120px;
            height: 140px;
            object-fit: cover;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            background: #007bff;
            color: #fff;
            padding: 8px;
            border-radius: 5px 5px 0 0;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -1px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>BIO-DATA</h2>

    <div class="photo">
        <img src="<?php echo $targetFile; ?>" alt="Uploaded Photo">
    </div>

    <!-- Personal Data -->
    <div class="section">
        <h3>PERSONAL DATA</h3>
        <table>
            <tr><td><b>Date:</b> <?php echo $data['date']; ?></td><td><b>Name:</b> <?php echo $data['fullname']; ?></td></tr>
            <tr><td><b>Gender:</b> <?php echo $data['gender']; ?></td><td><b>City Address:</b> <?php echo $data['city_address']; ?></td></tr>
            <tr><td><b>Cellphone:</b> <?php echo $data['cellphone']; ?></td><td><b>Provincial Address:</b> <?php echo $data['provincial_address']; ?></td></tr>
            <tr><td><b>Telephone:</b> <?php echo $data['telephone']; ?></td><td><b>Email:</b> <?php echo $data['email']; ?></td></tr>
            <tr><td><b>Birthplace:</b> <?php echo $data['birthplace']; ?></td><td><b>Date of Birth:</b> <?php echo $data['dob']; ?></td></tr>
            <tr><td><b>Citizenship:</b> <?php echo $data['citizenship']; ?></td><td><b>Civil Status:</b> <?php echo $data['civil_status']; ?></td></tr>
            <tr><td><b>Weight:</b> <?php echo $data['weight']; ?></td><td><b>Height:</b> <?php echo $data['height']; ?></td></tr>
            <tr><td><b>Religion:</b> <?php echo $data['religion']; ?></td><td><b>Spouse:</b> <?php echo $data['spouse']; ?></td></tr>
            <tr><td><b>Spouse Occupation:</b> <?php echo $data['spouse_occupation']; ?></td><td><b>Children:</b> <?php echo $data['children']; ?> (<?php echo $data['children_dob']; ?>)</td></tr>
            <tr><td><b>Father’s Name:</b> <?php echo $data['father_name']; ?></td><td><b>Occupation:</b> <?php echo $data['father_occupation']; ?></td></tr>
            <tr><td><b>Mother’s Name:</b> <?php echo $data['mother_name']; ?></td><td><b>Occupation:</b> <?php echo $data['mother_occupation']; ?></td></tr>
            <tr><td colspan="2"><b>Language/Dialect:</b> <?php echo $data['language']; ?></td></tr>
            <tr><td colspan="2"><b>Emergency Contact:</b> <?php echo $data['emergency_contact']; ?> (<?php echo $data['emergency_address']; ?>)</td></tr>
        </table>
    </div>

    <!-- Educational Background -->
    <div class="section">
        <h3>EDUCATIONAL BACKGROUND</h3>
        <table>
            <tr><td><b>Elementary:</b> <?php echo $data['elementary']; ?></td><td><b>Year:</b> <?php echo $data['elem_year']; ?></td></tr>
            <tr><td><b>High School:</b> <?php echo $data['highschool']; ?></td><td><b>Year:</b> <?php echo $data['hs_year']; ?></td></tr>
            <tr><td><b>College:</b> <?php echo $data['college']; ?></td><td><b>Year:</b> <?php echo $data['college_year']; ?></td></tr>
            <tr><td><b>Degree:</b> <?php echo $data['degree']; ?></td><td><b>Skills:</b> <?php echo $data['skills']; ?></td></tr>
        </table>
    </div>

    <!-- Employment -->
    <div class="section">
        <h3>EMPLOYMENT RECORD</h3>
        <table>
            <tr><td><b>Company 1:</b> <?php echo $data['company1']; ?></td><td><b>Position:</b> <?php echo $data['position1']; ?></td></tr>
            <tr><td><b>From:</b> <?php echo $data['from1']; ?></td><td><b>To:</b> <?php echo $data['to1']; ?></td></tr>
            <tr><td><b>Company 2:</b> <?php echo $data['company2']; ?></td><td><b>Position:</b> <?php echo $data['position2']; ?></td></tr>
            <tr><td><b>From:</b> <?php echo $data['from2']; ?></td><td><b>To:</b> <?php echo $data['to2']; ?></td></tr>
        </table>
    </div>

    <!-- Character Reference -->
    <div class="section">
        <h3>CHARACTER REFERENCE</h3>
        <table>
            <tr><td><b>Name:</b> <?php echo $data['ref1_name']; ?></td><td><b>Company:</b> <?php echo $data['ref1_company']; ?></td></tr>
            <tr><td><b>Position:</b> <?php echo $data['ref1_position']; ?></td><td><b>Contact:</b> <?php echo $data['ref1_contact']; ?></td></tr>
            <tr><td><b>Name:</b> <?php echo $data['ref2_name']; ?></td><td><b>Company:</b> <?php echo $data['ref2_company']; ?></td></tr>
            <tr><td><b>Position:</b> <?php echo $data['ref2_position']; ?></td><td><b>Contact:</b> <?php echo $data['ref2_contact']; ?></td></tr>
        </table>
    </div>

    <!-- Certification -->
    <div class="section">
        <h3>OTHER DETAILS</h3>
        <table>
            <tr><td><b>Res. Cert. No.:</b> <?php echo $data['res_cert']; ?></td><td><b>Issued At:</b> <?php echo $data['issued_at']; ?></td></tr>
            <tr><td><b>Issued On:</b> <?php echo $data['issued_on']; ?></td><td></td></tr>
        </table>
        <p style="margin-top:15px;">
            I hereby certify that the above information is true and correct to the best of my knowledge and belief.
        </p>
        <p><b>Signature: ___________________________</b></p>
    </div>
</div>

</body>
</html>



