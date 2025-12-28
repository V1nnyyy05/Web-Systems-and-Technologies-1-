<?php 
include '../config/db.php';
include '../includes/header.php';
include '../includes/functions.php';

// Security: Only allow Admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

// Handle User Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Prevent admin from deleting themselves
    if ($delete_id == $_SESSION['user_id']) {
        $message = "<p style='color:red;'>Error: You cannot delete your own account!</p>";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$delete_id])) {
            $message = "<p style='color:green;'>User deleted successfully.</p>";
            // Log the activity
            logActivity($pdo, $_SESSION['user_id'], "Deleted user ID: $delete_id");
        }
    }
}

// Fetch all users from thesis_db
$stmt = $pdo->query("SELECT id, username, role FROM users ORDER BY role ASC");
$users = $stmt->fetchAll();
?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>User Management</h2>
        <a href="../auth/register.php" class="btn" style="background:#27ae60;">+ Add New User</a>
    </div>

    <?php echo $message; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td>
                    <span class="status-<?php echo $user['role']; ?>" style="font-weight:bold; text-transform:capitalize;">
                        <?php echo $user['role']; ?>
                    </span>
                </td>
                <td>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <a href="manage_users.php?delete_id=<?php echo $user['id']; ?>" 
                           class="btn" 
                           style="background:#e74c3c; padding: 5px 10px; font-size: 12px;"
                           onclick="return confirm('Are you sure you want to delete this user?')">
                           Delete
                        </a>
                    <?php else: ?>
                        <small style="color:#999;">(Current Session)</small>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <a href="../index.php">← Back to Dashboard</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>