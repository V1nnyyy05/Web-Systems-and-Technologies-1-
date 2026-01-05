<!DOCTYPE html>
<html>
<head>
    <title>DTR Dashboard</title>
    <style>
        body { font-family: "Segoe UI", Tahoma, sans-serif; margin: 0; display: flex; color: #333; }
        /* Simple Sidebar */
        .sidebar { width: 220px; background: #222; color: white; min-height: 100vh; padding: 20px; }
        .sidebar img { border-radius: 50%; border: 2px solid #fff; margin-bottom: 10px; }
        
        /* Main Content */
        .main { flex: 1; padding: 30px; background: #fafafa; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        
        /* Table Style */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #eee; font-size: 0.9rem; }
        th a { text-decoration: none; color: #000; }
        
        /* Search Bar */
        .search-box { margin-bottom: 15px; }
        .search-box input { padding: 8px; width: 250px; border: 1px solid #ccc; }
        
        .btn-del { color: #d9534f; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="uploads/<?= $me['picture'] ?>" width="80" height="80">
    <p><strong><?= $me['fullname'] ?></strong></p>
    <p style="font-size: 0.8rem; color: #aaa;"><?= strtoupper($me['user_type']) ?></p>
    <hr>
    <a href="?delete_me=1" style="color: #ff8888; text-decoration: none; font-size: 0.8rem;" onclick="return confirm('Delete your account?')">Delete Account</a><br><br>
    <a href="logout.php" style="color: white; text-decoration: none;">Logout</a>
</div>

<div class="main">
    <div class="header">
        <h1>DTR Management System</h1>
    </div>

    <?php if ($me['user_type'] == 'admin'): ?>
        <h3>User Directory</h3>
        
        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by name or username..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <tr>
                <th><a href="?sort=username">Username ↑↓</a></th>
                <th><a href="?sort=fullname">Full Name ↑↓</a></th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $stmt_list->fetch()): ?>
            <tr>
                <td><?= $row['username'] ?></td>
                <td><?= $row['fullname'] ?></td>
                <td><?= ucfirst($row['user_type']) ?></td>
                <td>
                    <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn-del" onclick="return confirm('Delete this user?')">Remove</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Welcome to the Faculty portal. Use the sidebar to manage your profile.</p>
    <?php endif; ?>
</div>

</body>
</html>