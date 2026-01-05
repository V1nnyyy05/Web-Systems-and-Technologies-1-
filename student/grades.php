<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('student');

$studentId = $_SESSION['user_id'];

// Get all enrolled subjects and their grades
$query = "SELECT s.subject_code, s.subject_name, s.units, e.status, g.grade 
          FROM enrollments e
          JOIN subjects s ON e.subject_id = s.subject_id
          LEFT JOIN grades g ON e.enrollment_id = g.enrollment_id
          WHERE e.student_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$studentId]);
$grades = $stmt->fetchAll();

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link' href='profile.php'>My Profile</a></li>
  <li class='nav-item'><a class='nav-link' href='enrollment.php'>Enrollment</a></li>
  <li class='nav-item'><a class='nav-link active' href='grades.php'>Grades</a></li>
</ul>";

ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>My Academic Grades</h4>
</div>

<table class="table table-hover bg-white shadow-sm border">
    <thead class="table-light">
        <tr>
            <th>Code</th>
            <th>Subject Name</th>
            <th class="text-center">Units</th>
            <th class="text-center">Status</th>
            <th class="text-center">Final Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($grades) > 0): ?>
            <?php foreach($grades as $g): ?>
            <tr>
                <td><?= $g['subject_code'] ?></td>
                <td><?= $g['subject_name'] ?></td>
                <td class="text-center"><?= $g['units'] ?></td>
                <td class="text-center">
                    <span class="badge bg-<?= $g['status'] == 'enrolled' ? 'info' : 'success' ?>">
                        <?= ucfirst($g['status']) ?>
                    </span>
                </td>
                <td class="text-center fw-bold text-primary">
                    <?= $g['grade'] ?: '<span class="text-muted fw-normal">Pending</span>' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center p-4 text-muted">No enrollment records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php 
$content = ob_get_clean();
include '../includes/layout.php';
?>