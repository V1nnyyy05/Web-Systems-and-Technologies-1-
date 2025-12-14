<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
// Role-based access check
function checkRole($role) {
    if ($_SESSION['role'] !== $role) {
        die("Unauthorized access.");
    }
}