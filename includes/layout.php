<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrollment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary px-3">
  <span class="navbar-brand">Enrollment System</span>
  <div class="text-white">
      Logged in as: <b><?= ucfirst($_SESSION['role']) ?></b> | 
      <a href="../logout.php" class="text-white text-decoration-none">Logout</a>
  </div>
</nav>
<div class="container-fluid">
  <div class="row">
    <aside class="col-md-2 bg-white border-end min-vh-100 p-3">
      <?= $menu ?>
    </aside>
    <main class="col-md-10 p-4">
      <?= $content ?>
    </main>
  </div>
</div>
</body>
</html>