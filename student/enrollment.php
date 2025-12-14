<?php
require '../includes/auth.php'; 
require '../includes/db.php';   
checkRole('student');           

$studentId = $_SESSION['user_id'];
$message = "";


if (isset($_POST['enroll_subject'])) {
    $subjectId = $_POST['subject_id'];
    
    
    $check = $conn->prepare("SELECT enrollment_id FROM enrollments WHERE student_id = ? AND subject_id = ?");
    $check->execute([$studentId, $subjectId]);
    
    if ($check->rowCount() > 0) {
        $message = "<div class='alert alert-warning'>You are already enrolled in this subject.</div>";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO enrollments (student_id, subject_id, status) VALUES (?, ?, 'enrolled')");
        if ($stmt->execute([$studentId, $subjectId])) {
            $message = "<div class='alert alert-success'>Successfully enrolled in the subject!</div>";
        }
    }
}


$subjects = $conn->query("SELECT * FROM subjects ORDER BY subject_code ASC")->fetchAll();


$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link' href='profile.php'>My Profile</a></li>
  <li class='nav-item'><a class='nav-link active' href='enrollment.php'>Enrollment</a></li>
  <li class='nav-item'><a class='nav-link' href='grades.php'>Grades</a></li>
</ul>";

ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Subject Enrollment</h4>
    <span class="text-muted small">Academic Year 2024-2025</span>
</div>

<?= $message ?>

<div class="row">
    <?php if(count($subjects) > 0): ?>
        <?php foreach($subjects as $s): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary"><?= htmlspecialchars($s['subject_code']) ?></span>
                        <span class="text-muted small"><?= $s['units'] ?> Units</span>
                    </div>
                    <h6 class="card-title fw-bold"><?= htmlspecialchars($s['subject_name']) ?></h6>
                    
                    <form method="POST" class="mt-3">
                        <input type="hidden" name="subject_id" value="<?= $s['subject_id'] ?>">
                        <button type="submit" name="enroll_subject" class="btn btn-sm btn-outline-primary w-100">
                            Add Subject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <p class="text-muted">No subjects available for enrollment at this time.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include '../includes/layout.php'; // Render the final page using the layout template
?>

