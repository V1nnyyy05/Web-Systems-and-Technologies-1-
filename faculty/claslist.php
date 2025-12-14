<?php
require '../includes/auth.php'; //
require '../includes/db.php';   //
checkRole('faculty');           //

// Fetch all students and their enrollment counts for this faculty view
$query = "SELECT u.*, 
          (SELECT COUNT(*) FROM enrollments e WHERE e.student_id = u.user_id) as subject_count 
          FROM users u 
          WHERE u.role = 'student' 
          ORDER BY u.last_name ASC";
$stmt = $conn->query($query);
$students = $stmt->fetchAll();

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link active fw-bold text-primary' href='claslist.php'>Class List</a></li>
  <li class='nav-item'><a class='nav-link' href='grade_submit.php'>Submit Grades</a></li>
</ul>";

ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Master Class List</h4>
    <span class="badge bg-secondary"><?= count($students) ?> Total Students</span>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Student Info</th>
                        <th>Student No</th>
                        <th class="text-center">Subjects</th>
                        <th class="text-center">Signature</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($students) > 0): ?>
                        <?php foreach($students as $student): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="../assets/uploads/<?= $student['profile_image'] ?: 'default.png' ?>" 
                                         class="rounded-circle border me-3" width="45" height="45" style="object-fit: cover;">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($student['first_name'] . " " . $student['last_name']) ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($student['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-dark"><?= $student['student_no'] ?></code></td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light text-dark border"><?= $student['subject_count'] ?></span>
                            </td>
                            <td class="text-center">
                                <img src="../assets/uploads/signatures/<?= $student['signature_image'] ?: 'nosig.png' ?>" 
                                     class="border bg-white" height="35" style="max-width: 80px;">
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Enrolled</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="student_profile.php?id=<?= $student['user_id'] ?>" 
                                   class="btn btn-sm btn-outline-primary shadow-sm">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No students found in the database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include '../includes/layout.php'; //
?>