<?php 
include '../config/db.php';
include '../includes/header.php';

$error = ""; $message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    if ($stmt->rowCount() > 0) {
        $error = "Username already exists!";
    } else {
        $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $ins = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        if ($ins->execute([$_POST['username'], $hashed, $_POST['role']])) {
            $message = "Account created! <a href='login.php'>Login here</a>";
        }
    }
}
?>
<div class="login-container">
    <h2>Create Account</h2>
    <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
    <?php if($message) echo "<p style='color:green'>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <select name="role" required>
            <option value="student">Student</option>
            <option value="adviser">Adviser</option>
        </select>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn" style="width:100%">Register</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>