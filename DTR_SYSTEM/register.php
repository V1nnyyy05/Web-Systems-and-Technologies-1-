<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $user_type = $_POST['user_type'];
    
    // Hash password for security
    $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Handle File Upload
    $pic_name = time() . '_' . $_FILES['picture']['name']; // Added time() to prevent overwriting same names
    $target = "uploads/" . $pic_name;

    if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, user_type, picture) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $pass_hash, $fullname, $user_type, $pic_name]);
        
        echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
    } else {
        echo "Failed to upload picture.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DTR System - Register</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 25px; border: 1px solid #ddd; width: 320px; box-shadow: 2px 2px 5px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; font-size: 1.2rem; color: #333; border-bottom: 2px solid #333; padding-bottom: 5px; text-align: center; }
        label { font-size: 0.8rem; color: #666; }
        input, select { width: 100%; padding: 8px; margin: 5px 0 15px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #333; color: white; border: none; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #555; }
        .link { font-size: 0.8rem; text-align: center; display: block; margin-top: 10px; color: #666; text-decoration: none; }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Full Name</label>
            <input type="text" name="fullname" placeholder="Juan Dela Cruz" required>
            
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" required>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="********" required>
            
            <label>User Type</label>
            <select name="user_type">
                <option value="faculty">Faculty</option>
                <option value="admin">Admin</option>
            </select>
            
            <label>Profile Picture</label>
            <input type="file" name="picture" accept="image/*" required>
            
            <button type="submit">Register Now</button>
        </form>
        <a href="login.php" class="link">Already have an account? Login here</a>
    </div>
</body>
</html>