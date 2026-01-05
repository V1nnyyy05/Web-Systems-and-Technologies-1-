<?php
ob_start(); 
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
$fullname = $_SESSION['fullname'];
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Supply Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --brand-purple: #3e1f77;
            --brand-dark: #2a1a4f;
            --brand-accent: #ffd56a;
            --brand-hover: #5a2bb5;
        }

        body { 
            background:#f8f9fa; 
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
            min-height:100vh; 
            display:flex; 
            flex-direction:column; 
        }
        
        /* 1. TOPBAR & DESKTOP TABS */
        .topbar { 
            background: var(--brand-purple); 
            color: white; 
            padding: 0 25px; 
            position: sticky; 
            top: 0; 
            z-index: 1020; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            height: 70px;
            display: flex;
            align-items: center;
        }

        .brand { 
            font-size: 20px; 
            font-weight: 800; 
            text-decoration: none; 
            color: white; 
            letter-spacing: -0.5px;
            white-space: nowrap;
        }

        .nav-tabs-custom {
            display: none; /* Hidden on mobile */
            gap: 5px;
            height: 100%;
            align-items: center;
        }

        .nav-tab-item {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-tab-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-tab-item.active {
            color: white;
            background: var(--brand-hover);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        /* 2. MOBILE DRAWER STYLES */
        .offcanvas { background-color: var(--brand-dark); color: white; width: 280px !important; }
        .drawer-link { 
            color: rgba(255,255,255,0.8); 
            text-decoration: none; 
            padding: 14px 20px; 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            border-radius: 10px; 
            margin: 4px 15px; 
            font-weight: 500;
        }
        .drawer-link:hover, .drawer-link.active { background: var(--brand-hover); color: var(--brand-accent); }

        @media (min-width: 992px) {
            .nav-tabs-custom { display: flex; }
            .mobile-toggle { display: none; }
        }

        /* 3. HOME CONTENT STYLES */
        .hero { background:white; border-radius:16px; padding:40px; margin-top:25px; border: 1px solid rgba(0,0,0,0.05); box-shadow:0 10px 30px rgba(0,0,0,0.04); }
        .big-title { font-size:30px; font-weight:800; color: var(--brand-dark); letter-spacing: -1px; }
        .stat-card { border-radius:16px; padding:25px; color:white; border: none; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .purple { background:#5a2bb5; } .blue { background:#0096ff; } .pink { background:#ff4d8b; } .orange { background:#ff9f3f; }
        .global-footer { background: var(--brand-dark); color: rgba(255,255,255,0.6); padding:20px; margin-top:auto; text-align:center; font-size: 13px; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="container-fluid d-flex justify-content-between align-items-center h-100">
        <div class="d-flex align-items-center h-100">
            <button class="btn text-white p-0 me-3 mobile-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#navDrawer">
                <i class="bi bi-list fs-2"></i>
            </button>
            
            <a href="dashboard.php" class="brand me-4">
                <i class="bi bi-box-seam-fill me-2 text-warning"></i>SUPPLY INV
            </a>

            <nav class="nav-tabs-custom">
                <?php if ($role == "Admin"): ?>
                    <a class="nav-tab-item <?= $page=='home'?'active':'' ?>" href="dashboard.php"><i class="bi bi-house-door"></i> Home</a>
                    <a class="nav-tab-item <?= $page=='users'?'active':'' ?>" href="dashboard.php?page=users"><i class="bi bi-people"></i> Users</a>
                    <a class="nav-tab-item <?= $page=='categories'?'active':'' ?>" href="dashboard.php?page=categories"><i class="bi bi-tags"></i> Categories</a>
                    <a class="nav-tab-item <?= $page=='items'?'active':'' ?>" href="dashboard.php?page=items"><i class="bi bi-box"></i> Items</a>
                    <a class="nav-tab-item <?= $page=='stock'?'active':'' ?>" href="dashboard.php?page=stock"><i class="bi bi-stack"></i> Stock</a>
                    <a class="nav-tab-item <?= $page=='requests'?'active':'' ?>" href="dashboard.php?page=requests"><i class="bi bi-card-list"></i> Requests</a>
                    <a class="nav-tab-item <?= $page=='reports'?'active':'' ?>" href="dashboard.php?page=reports"><i class="bi bi-bar-chart"></i> Reports</a>
                <?php else: ?>
                    <a class="nav-tab-item <?= $page=='home'?'active':'' ?>" href="dashboard.php"><i class="bi bi-house-door"></i> Home</a>
                    <a class="nav-tab-item <?= $page=='request_supply'?'active':'' ?>" href="dashboard.php?page=request_supply"><i class="bi bi-pencil-square"></i> Request</a>
                    <a class="nav-tab-item <?= $page=='view_stock'?'active':'' ?>" href="dashboard.php?page=view_stock"><i class="bi bi-box"></i> Stock</a>
                    <a class="nav-tab-item <?= $page=='my_requests'?'active':'' ?>" href="dashboard.php?page=my_requests"><i class="bi bi-history"></i> My History</a>
                <?php endif; ?>
            </nav>
        </div>

        <div class="d-flex align-items-center">
            <div class="d-none d-md-flex flex-column text-end me-3">
                <span class="small fw-bold lh-1"><?= $fullname ?></span>
                <span class="opacity-50 lh-1" style="font-size: 11px;"><?= $role ?></span>
            </div>
            <button onclick="confirmLogout()" class="btn btn-warning btn-sm fw-bold px-3 rounded-pill shadow-sm">Logout</button>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="navDrawer">
    <div class="offcanvas-header py-4">
        <h5 class="offcanvas-title fw-bold">Menu Navigation</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0 pt-2">
        <?php if ($role=="Admin"): ?>
            <a class="drawer-link <?= $page=='home'?'active':'' ?>" href="dashboard.php"><i class="bi bi-house-door-fill"></i> Home</a>
            <a class="drawer-link <?= $page=='users'?'active':'' ?>" href="dashboard.php?page=users"><i class="bi bi-people-fill"></i> Users</a>
            <a class="drawer-link <?= $page=='categories'?'active':'' ?>" href="dashboard.php?page=categories"><i class="bi bi-tags-fill"></i> Categories</a>
            <a class="drawer-link <?= $page=='items'?'active':'' ?>" href="dashboard.php?page=items"><i class="bi bi-box-fill"></i> Items</a>
            <a class="drawer-link <?= $page=='stock'?'active':'' ?>" href="dashboard.php?page=stock"><i class="bi bi-stack"></i> Stock</a>
            <a class="drawer-link <?= $page=='requests'?'active':'' ?>" href="dashboard.php?page=requests"><i class="bi bi-card-list"></i> Requests</a>
            <a class="drawer-link <?= $page=='reports'?'active':'' ?>" href="dashboard.php?page=reports"><i class="bi bi-bar-chart-fill"></i> Reports</a>
        <?php else: ?>
            <a class="drawer-link <?= $page=='home'?'active':'' ?>" href="dashboard.php"><i class="bi bi-house-door-fill"></i> Home</a>
            <a class="drawer-link <?= $page=='request_supply'?'active':'' ?>" href="dashboard.php?page=request_supply"><i class="bi bi-pencil-square"></i> Request Supplies</a>
            <a class="drawer-link <?= $page=='view_stock'?'active':'' ?>" href="dashboard.php?page=view_stock"><i class="bi bi-box"></i> View Stock</a>
            <a class="drawer-link <?= $page=='my_requests'?'active':'' ?>" href="dashboard.php?page=my_requests"><i class="bi bi-card-checklist"></i> My Requests</a>
        <?php endif; ?>
    </div>
</div>

<div class="container flex-grow-1 pb-5">
    <?php
    if ($role == "Admin") {
        if ($page == 'home') {
            $total_users = $conn->query("SELECT COUNT(*) as t FROM users")->fetch_assoc()['t'];
            $total_categories = $conn->query("SELECT COUNT(*) as t FROM categories")->fetch_assoc()['t'];
            $total_items = $conn->query("SELECT COUNT(*) as t FROM items")->fetch_assoc()['t'];
            $pending_requests = $conn->query("SELECT COUNT(*) as t FROM requests WHERE status='Pending'")->fetch_assoc()['t'];
            ?>
            <div class="hero mb-4">
                <div class="big-title">Supply & Inventory Management</div>
                <p class="text-muted mt-2 mb-0">Professional tracking system for enterprise office materials.</p>
            </div>
            <div class="row g-3">
                <div class="col-md-3"><div class="stat-card purple d-flex justify-content-between align-items-center shadow-sm"><div><h6 class="opacity-75 small text-uppercase fw-bold">Total Users</h6><h2 class="fw-bold m-0"><?= $total_users ?></h2></div><i class="bi bi-people-fill fs-1 opacity-25"></i></div></div>
                <div class="col-md-3"><div class="stat-card blue d-flex justify-content-between align-items-center shadow-sm"><div><h6 class="opacity-75 small text-uppercase fw-bold">Total Categories</h6><h2 class="fw-bold m-0"><?= $total_categories ?></h2></div><i class="bi bi-tags-fill fs-1 opacity-25"></i></div></div>
                <div class="col-md-3"><div class="stat-card pink d-flex justify-content-between align-items-center shadow-sm"><div><h6 class="opacity-75 small text-uppercase fw-bold">Total Items</h6><h2 class="fw-bold m-0"><?= $total_items ?></h2></div><i class="bi bi-box-seam fs-1 opacity-25"></i></div></div>
                <div class="col-md-3"><div class="stat-card orange d-flex justify-content-between align-items-center shadow-sm"><div><h6 class="opacity-75 small text-uppercase fw-bold">Pending Requests</h6><h2 class="fw-bold m-0"><?= $pending_requests ?></h2></div><i class="bi bi-hourglass-split fs-1 opacity-25"></i></div></div>
            </div>
            <h5 class="mt-5 mb-3 fw-bold text-dark"><i class="bi bi-star-fill text-warning me-2"></i>System Highlights</h5>
            <div class="row g-4 text-center">
                <div class="col-md-3"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3 text-primary"><i class="bi bi-building fs-3"></i></div><h6 class="fw-bold">Multi-Department</h6><p class="small text-muted mb-0">Supports multiple offices across the organization.</p></div></div>
                <div class="col-md-3"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3 text-success"><i class="bi bi-activity fs-3"></i></div><h6 class="fw-bold">Live Monitoring</h6><p class="small text-muted mb-0">Real-time updates on stock levels and transactions.</p></div></div>
                <div class="col-md-3"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3 text-info"><i class="bi bi-journal-text fs-3"></i></div><h6 class="fw-bold">Organized Records</h6><p class="small text-muted mb-0">Structured categories and items list for easy management.</p></div></div>
                <div class="col-md-3"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3 text-danger"><i class="bi bi-file-earmark-pdf fs-3"></i></div><h6 class="fw-bold">Report Ready</h6><p class="small text-muted mb-0">Easily generate and print professional inventory reports.</p></div></div>
            </div>
            <?php
        }
        switch($page){
            case 'users': case 'categories': case 'items': case 'stock': case 'requests': case 'reports':
                include "admin/{$page}.php"; break;
        }
    } else {
        if ($page == 'home') {
            ?>
            <div class="hero mb-4">
                <div class="big-title">Staff Resource Center</div>
                <p class="text-muted mt-2 mb-0">Request and monitor office supplies in one professional platform.</p>
            </div>
            <div class="row g-4 mt-2 text-center">
                <div class="col-md-4"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3"><i class="bi bi-pencil-square fs-1 text-primary"></i></div><h5 class="fw-bold">Request Supplies</h5><p class="small text-muted">Submit a new request for materials.</p><a href="dashboard.php?page=request_supply" class="btn btn-primary btn-sm mt-auto shadow-sm rounded-pill px-4">Open Module</a></div></div>
                <div class="col-md-4"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3"><i class="bi bi-box-seam fs-1 text-success"></i></div><h5 class="fw-bold">View Stock</h5><p class="small text-muted">Check real-time inventory availability.</p><a href="dashboard.php?page=view_stock" class="btn btn-success btn-sm mt-auto shadow-sm rounded-pill px-4">Open Module</a></div></div>
                <div class="col-md-4"><div class="card hero p-4 h-100 border-0 shadow-sm"><div class="mb-3"><i class="bi bi-card-checklist fs-1 text-warning"></i></div><h5 class="fw-bold">My Requests</h5><p class="small text-muted">Track the status of your submissions.</p><a href="dashboard.php?page=my_requests" class="btn btn-warning btn-sm mt-auto shadow-sm rounded-pill px-4 text-dark fw-bold">Open Module</a></div></div>
            </div>
            <?php
        }
        switch($page){
            case 'request_supply': case 'view_stock': case 'my_requests':
                include "staff/{$page}.php"; break;
        }
    }
    ?>
</div>

<div class="global-footer">
    <div>© <?= date('Y'); ?> Supply Inventory Management System • Ver 3.0</div>
</div>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Ready to Leave?',
        text: "Are you sure you want to end your session?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3e1f77',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout',
        cancelButtonText: 'Stay'
    }).then((result) => { if (result.isConfirmed) { window.location.href = 'logout.php'; } });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>