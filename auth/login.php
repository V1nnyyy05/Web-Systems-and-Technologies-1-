<?php 
include '../config/db.php';
include '../includes/header.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<div class="login-container">
    <h2>System Login</h2>
    <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn" style="width:100%">Login</button>
    </form>
    <p>New user? <a href="register.php">Register here</a></p>
</div>
<?php include '../includes/footer.php'; ?>