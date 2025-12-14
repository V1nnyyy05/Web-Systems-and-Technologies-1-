<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('admin');

$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$subjectCount = $conn->query("SELECT COUNT(*) FROM subjects")->fetchColumn();
$enrollCount = $conn->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link active' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link' href='users.php'>Manage Users</a></li>
  <li class='nav-item'><a class='nav-link' href='subjects.php'>Manage Subjects</a></li>
</ul>";

ob_start(); ?>
<h4>Administrator Overview</h4>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5>Total Users</h5>
                <h2><?= $userCount ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5>Subjects Offered</h5>
                <h2><?= $subjectCount ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark mb-3">
            <div class="card-body">
                <h5>Total Enrollments</h5>
                <h2><?= $enrollCount ?></h2>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
include '../includes/layout.php';