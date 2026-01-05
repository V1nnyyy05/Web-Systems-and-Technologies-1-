<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('admin');

$message = "";

// Process Adding New User
if (isset($_POST['add_user'])) {
    $role = $_POST['role'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $email = $_POST['email'];
    $s_no  = $_POST['student_no'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (role, first_name, last_name, email, student_no, password_hash) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$role, $fname, $lname, $email, $s_no, $pass]);
        $message = "<div class='alert alert-success'>User added successfully!</div>";
    } catch (Exception $e) {
        $message = "<div class='alert alert-danger'>Error: Email might already exist.</div>";
    }
}

$users = $conn->query("SELECT * FROM users ORDER BY role ASC")->fetchAll();

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link active' href='users.php'>Manage Users</a></li>
  <li class='nav-item'><a class='nav-link' href='subjects.php'>Manage Subjects</a></li>
</ul>";

ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>User Management</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
</div>

<?= $message ?>

<table class="table bg-white shadow-sm">
    <thead><tr><th>ID</th><th>Role</th><th>Name</th><th>Email</th><th>Student/Employee No.</th></tr></thead>
    <tbody>
        <?php foreach($users as $u): ?>
        <tr>
            <td><?= $u['user_id'] ?></td>
            <td><span class="badge bg-secondary"><?= strtoupper($u['role']) ?></span></td>
            <td><?= $u['first_name'] . " " . $u['last_name'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['student_no'] ?? 'N/A' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST">
      <div class="modal-header"><h5 class="modal-title">Add New User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <select name="role" class="form-select mb-2" required>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
            <option value="admin">Administrator</option>
        </select>
        <input type="text" name="first_name" placeholder="First Name" class="form-control mb-2" required>
        <input type="text" name="last_name" placeholder="Last Name" class="form-control mb-2" required>
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
        <input type="text" name="student_no" placeholder="Student/Employee ID" class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_user" class="btn btn-primary">Save User</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php 
$content = ob_get_clean();
include '../includes/layout.php';