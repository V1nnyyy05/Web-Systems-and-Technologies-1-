<?php
include 'config/db.php';
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header("Location: auth/login.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Handle Profile Pic
    if (!empty($_FILES['pic']['name'])) {
        $picName = time() . "_pic_" . $_FILES['pic']['name'];
        move_uploaded_file($_FILES['pic']['tmp_name'], "assets/uploads/" . $picName);
        $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?")->execute([$picName, $user_id]);
    }

    // Handle Signature
    if (!empty($_FILES['sig']['name'])) {
        $sigName = time() . "_sig_" . $_FILES['sig']['name'];
        move_uploaded_file($_FILES['sig']['tmp_name'], "assets/uploads/" . $sigName);
        $pdo->prepare("UPDATE users SET signature = ? WHERE id = ?")->execute([$sigName, $user_id]);
    }
    echo "<p class='container' style='color:green;'>Profile updated successfully!</p>";
}
?>

<div class="container">
    <div class="card">
        <h2>Update Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Profile Picture:</label>
            <input type="file" name="pic" accept="image/*">
            
            <label>Digital Signature (Image):</label>
            <input type="file" name="sig" accept="image/*">
            
            <button type="submit" class="btn">Save Changes</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>