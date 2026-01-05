<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('student');

$studentId = $_SESSION['user_id'];
$message = "";

// Handle Profile Updates
if (isset($_POST['update_profile'])) {
    $targetDir = "../assets/uploads/";
    $sigDir = $targetDir . "signatures/";

    // Update Profile Image
    if (!empty($_FILES["profile_pic"]["name"])) {
        $fileName = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetDir . $fileName)) {
            $conn->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?")->execute([$fileName, $studentId]);
        }
    }

    // Update Signature
    if (!empty($_FILES["signature_pic"]["name"])) {
        $sigName = time() . "_" . basename($_FILES["signature_pic"]["name"]);
        if (move_uploaded_file($_FILES["signature_pic"]["tmp_name"], $sigDir . $sigName)) {
            $conn->prepare("UPDATE users SET signature_image = ? WHERE user_id = ?")->execute([$sigName, $studentId]);
        }
    }
    $message = "<div class='alert alert-success'>Profile updated!</div>";
}

// Fetch current data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$studentId]);
$user = $stmt->fetch();

$menu = "<ul class='nav flex-column'><li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li><li class='nav-item'><a class='nav-link active' href='profile.php'>My Profile</a></li><li class='nav-item'><a class='nav-link' href='enrollment.php'>Enrollment</a></li></ul>";

ob_start(); ?>
<div class="card shadow-sm p-4 mx-auto" style="max-width:500px">
    <h5 class="mb-4">Edit Profile</h5>
    <?= $message ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="text-center mb-4">
            <img src="../assets/uploads/<?= $user['profile_image'] ?: 'default.png' ?>" class="rounded-circle border" width="100" height="100" style="object-fit:cover;">
            <input type="file" name="profile_pic" class="form-control form-control-sm mt-2">
            <small class="text-muted d-block mt-1">Student No: <?= $user['student_no'] ?></small>
        </div>
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" value="<?= $user['first_name'].' '.$user['last_name'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Signature</label>
            <div class="border bg-light p-2 mb-2 text-center">
                <img src="../assets/uploads/signatures/<?= $user['signature_image'] ?: 'nosig.png' ?>" height="60">
            </div>
            <input type="file" name="signature_pic" class="form-control form-control-sm">
        </div>
        <button type="submit" name="update_profile" class="btn btn-primary w-100">Save Changes</button>
    </form>
</div>
<?php 
$content = ob_get_clean();
include '../includes/layout.php'; ?>