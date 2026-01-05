<?php 
include '../config/db.php';
include '../includes/header.php';

if($_SESSION['role'] != 'adviser') header("Location: ../index.php");

if (isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE theses SET status = ?, comment = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['comment'], $_POST['thesis_id']]);
}

$submissions = $pdo->query("SELECT t.*, u.username FROM theses t JOIN users u ON t.student_id = u.id")->fetchAll();
?>
<h2>Review Submissions</h2>
<table>
    <tr><th>Student</th><th>Title</th><th>File</th><th>Status</th><th>Action</th></tr>
    <?php foreach($submissions as $s): ?>
    <tr>
        <td><?php echo $s['username']; ?></td>
        <td><?php echo $s['title']; ?></td>
        <td><a href="../assets/uploads/<?php echo $s['file_path']; ?>">View PDF</a></td>
        <td><strong><?php echo $s['status']; ?></strong></td>
        <td>
            <form method="POST">
                <input type="hidden" name="thesis_id" value="<?php echo $s['id']; ?>">
                <input type="text" name="comment" placeholder="Add comment">
                <select name="status">
                    <option value="Approved">Approve</option>
                    <option value="Rejected">Reject</option>
                </select>
                <button type="submit" name="update_status">Update</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?>