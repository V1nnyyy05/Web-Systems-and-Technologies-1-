<?php
require '../includes/auth.php';
require '../includes/db.php';
checkRole('faculty');

$menu = "
<ul class='nav flex-column'>
  <li class='nav-item'><a class='nav-link active' href='dashboard.php'>Dashboard</a></li>
  <li class='nav-item'><a class='nav-link' href='grade_submit.php'>Submit Grades</a></li>
  <li class='nav-item'><a class='nav-link' href='claslist.php'>Class List</a></li>
</ul>";

$content = "
<h4>Faculty Portal</h4>
<p>Welcome, Prof. " . $_SESSION['first_name'] . "</p>
<div class='alert alert-info'>Use the sidebar to view your class lists or encode student grades.</div>";

include '../includes/layout.php';