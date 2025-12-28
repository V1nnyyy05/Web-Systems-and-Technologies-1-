<?php
include '../config/db.php';
include '../includes/header.php';
include '../includes/functions.php'; // For checkLogin()
checkLogin();

if($_SESSION['role'] !== 'adviser') { header("Location: ../index.php"); exit(); }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM theses WHERE status = 'Pending'");
$stmt->execute();
$pending_count = $stmt->fetchColumn();
?>

<div class="container">
    <h2>Adviser Overview</h2>
    <div class="dashboard-grid">
        <div class="card" style="border-left-color: var(--success);">
            <h3>Pending Reviews</h3>
            <p>You have <strong><?php echo $pending_count; ?></strong> new theses awaiting your feedback.</p>
            <a href="review.php" class="btn" style="background:var(--success)">Go to Review Page</a>
        </div>
        
        <div class="card">
            <h3>Quick Links</h3>
            <p><a href="../profile.php">Update Signature</a></p>
            <p><a href="../index.php">Back to Main</a></p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>