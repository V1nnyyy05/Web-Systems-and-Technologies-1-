<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('faculty');

if (isset($_POST['save_grade'])) {
    $e_id = $_POST['enrollment_id'];
    $grade = $_POST['grade'];
    $f_id = $_SESSION['user_id'];

    // Check if record exists
    $check = $conn->prepare("SELECT grade_id FROM grades WHERE enrollment_id = ?");
    $check->execute([$e_id]);
    
    if ($check->rowCount() > 0) {
        $stmt = $conn->prepare("UPDATE grades SET grade = ?, faculty_id = ? WHERE enrollment_id = ?");
        $stmt->execute([$grade, $f_id, $e_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO grades (enrollment_id, faculty_id, grade) VALUES (?, ?, ?)");
        $stmt->execute([$e_id, $f_id, $grade]);
    }
}

$list = $conn->query("SELECT e.enrollment_id, u.first_name, u.last_name, s.subject_name, g.grade 
                      FROM enrollments e 
                      JOIN users u ON e.student_id = u.user_id 
                      JOIN subjects s ON e.subject_id = s.subject_id 
                      LEFT JOIN grades g ON e.enrollment_id = g.enrollment_id")->fetchAll();

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link active' href='grade_submit.php'>Submit Grades</a></li>
</ul>";

ob_start(); ?>
<h4>Encode Grades</h4>
<table class="table table-striped bg-white shadow-sm mt-3">
    <thead><tr><th>Student</th><th>Subject</th><th>Grade</th><th>Action</th></tr></thead>
    <tbody>
        <?php foreach($list as $row): ?>
        <tr>
            <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
            <td><?= $row['subject_name'] ?></td>
            <form method="POST">
                <td>
                    <select name="grade" class="form-select form-select-sm" style="width:100px">
                        <option value="">--</option>
                        <?php foreach(['1.0','1.25','1.5','1.75','2.0','3.0','5.0'] as $val): ?>
                            <option value="<?= $val ?>" <?= $row['grade'] == $val ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="enrollment_id" value="<?= $row['enrollment_id'] ?>">
                    <button name="save_grade" class="btn btn-sm btn-success">Save</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php 
$content = ob_get_clean();
include '../includes/layout.php';