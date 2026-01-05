<?php 
include 'config/db.php';
include 'includes/header.php'; 

if (!isset($_SESSION['role'])) {
    header("Location: auth/login.php");
    exit();
}
?>
<div class="container">
    <h1>Main Dashboard</h1>
    <div class="dashboard-grid">
        <div class="card">
            <h3>Profile</h3>
            <a href="profile.php" class="btn">Update Profile/Signature</a>
        </div>
        <?php if($_SESSION['role'] == 'student'): ?>
            <div class="card">
                <h3>Submit Thesis</h3>
                <a href="student/upload_thesis.php" class="btn">Upload Files</a>
            </div>
        <?php elseif($_SESSION['role'] == 'adviser'): ?>
            <div class="card">
                <h3>Review</h3>
                <a href="adviser/review.php" class="btn">Open Review Panel</a>
            </div>
        <?php elseif($_SESSION['role'] == 'admin'): ?>
            <div class="card">
                <h3>Admin Control</h3>
                <a href="admin/manage_users.php" class="btn">Manage Users</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>