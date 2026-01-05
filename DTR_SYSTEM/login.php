<!DOCTYPE html>
<html>
<head>
    <title>DTR System - Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 25px; border: 1px solid #ddd; width: 300px; box-shadow: 2px 2px 5px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; font-size: 1.2rem; color: #333; border-bottom: 2px solid #333; padding-bottom: 5px; }
        input, select { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #333; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #555; }
        .link { font-size: 0.8rem; text-align: center; display: block; margin-top: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h2>DTR System Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php" class="link">Don't have an account? Register</a>
    </div>
</body>
</html>