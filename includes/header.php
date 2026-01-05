<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
// Dynamically determine the base path for assets and links
$base_path = (file_exists('assets/style.css')) ? '' : '../';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/style.css">
    <title>Thesis Archive</title>
</head>
<body>
<nav class="navbar">
    <div class="container">
        <a href="<?php echo $base_path; ?>index.php"><strong>ThesisSystem</strong></a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <span>(<?php echo htmlspecialchars($_SESSION['role']); ?>)</span>
            <a href="<?php echo $base_path; ?>auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo $base_path; ?>auth/login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>
<div class="container main-content">