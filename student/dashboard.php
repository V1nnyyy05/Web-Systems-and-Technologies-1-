<?php
require '../includes/auth.php'; 
require '../includes/db.php';   
checkRole('student');           

$studentId = $_SESSION['user_id']; 


$stmtUser = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmtUser->execute([$studentId]);
$user = $stmtUser->fetch();


$querySubjects = "SELECT s.subject_code, s.subject_name, s.units 
                  FROM enrollments e 
                  JOIN subjects s ON e.subject_id = s.subject_id 
                  WHERE e.student_id = ? AND e.status = 'enrolled'";
$stmtSubjects = $conn->prepare($querySubjects);
$stmtSubjects->execute([$studentId]);
$enrolledSubjects = $stmtSubjects->fetchAll();


$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link active fw-bold text-primary' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link' href='profile.php'>My Profile</a></li>
  <li class='nav-item'><a class='nav-link' href='enrollment.php'>Enrollment</a></li>
  <li class='nav-item'><a class='nav-link' href='grades.php'>Grades</a></li>
</ul>";

ob_start(); ?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <div class="mb-3">
                <img src="../assets/uploads/<?= $user['profile_image'] ?: 'default.png' ?>" 
                     class="rounded-circle border" width="100" height="100" style="object-fit: cover;">
            </div>
            <h5 class="fw-bold mb-1"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h5>
            <p class="text-muted small mb-3"><?= htmlspecialchars($user['email']) ?></p>
            <hr>
            <div class="text-start">
                <p class="small mb-1"><strong>Student No:</strong> <?= htmlspecialchars($user['student_no']) ?></p>
                <p class="small mb-0"><strong>Role:</strong> <span class="badge bg-info text-dark">Student</span></p>
            </div>
            <a href="profile.php" class="btn btn-outline-primary btn-sm mt-3 w-100">View Full Profile</a>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">Currently Enrolled Subjects</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Subject Name</th>
                                <th class="text-center">Units</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($enrolledSubjects) > 0): ?>
                                <?php foreach ($enrolledSubjects as $subject): ?>
                                <tr>
                                    <td class="fw-bold text-primary"><?= htmlspecialchars($subject['subject_code']) ?></td>
                                    <td><?= htmlspecialchars($subject['subject_name']) ?></td>
                                    <td class="text-center"><?= $subject['units'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        You are not enrolled in any subjects yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 text-end">
                <a href="enrollment.php" class="btn btn-primary btn-sm">Manage Enrollment</a>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include '../includes/layout.php'; //
?>