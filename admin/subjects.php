<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('admin');

$message = "";

// 1. Handle Adding a New Subject
if (isset($_POST['add_subject'])) {
    $code  = $_POST['subject_code'];
    $name  = $_POST['subject_name'];
    $units = $_POST['units'];

    try {
        $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name, units) VALUES (?, ?, ?)");
        $stmt->execute([$code, $name, $units]);
        $message = "<div class='alert alert-success'>Subject '$name' added successfully!</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error adding subject: " . $e->getMessage() . "</div>";
    }
}

// 2. Handle Deletion (Optional but helpful)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM subjects WHERE subject_id = ?");
    $stmt->execute([$id]);
    header("Location: subjects.php?msg=deleted");
    exit();
}

// 3. Fetch all subjects for the table
$subjects = $conn->query("SELECT * FROM subjects ORDER BY subject_code ASC")->fetchAll();

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link' href='users.php'>Manage Users</a></li>
  <li class='nav-item'><a class='nav-link active' href='subjects.php'>Manage Subjects</a></li>
</ul>";

ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Subject Management</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
        + Add New Subject
    </button>
</div>

<?= $message ?>
<?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted') echo "<div class='alert alert-info'>Subject removed.</div>"; ?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Subject Name</th>
                    <th class="text-center">Units</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($subjects) > 0): ?>
                    <?php foreach($subjects as $s): ?>
                    <tr>
                        <td class="fw-bold"><?= $s['subject_code'] ?></td>
                        <td><?= $s['subject_name'] ?></td>
                        <td class="text-center"><?= $s['units'] ?></td>
                        <td class="text-center">
                            <a href="?delete=<?= $s['subject_id'] ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure you want to delete this subject?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center p-4 text-muted">No subjects found in the database.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Create New Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Subject Code</label>
            <input type="text" name="subject_code" class="form-control" placeholder="e.g., CS101" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject_name" class="form-control" placeholder="e.g., Introduction to Computing" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Units</label>
            <input type="number" name="units" class="form-control" min="1" max="5" value="3" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="add_subject" class="btn btn-primary">Save Subject</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php 
$content = ob_get_clean();
include '../includes/layout.php';
?>