<?php
include '../config/db.php';
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') die("Access Denied");

$logs = $pdo->query("SELECT logs.*, users.username FROM logs JOIN users ON logs.user_id = users.id ORDER BY created_at DESC")->fetchAll();
?>

<h2>System Activity Logs</h2>
<table>
    <tr><th>User</th><th>Action</th><th>Timestamp</th></tr>
    <?php foreach($logs as $l): ?>
    <tr>
        <td><?php echo $l['username']; ?></td>
        <td><?php echo $l['action']; ?></td>
        <td><?php echo $l['created_at']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?>