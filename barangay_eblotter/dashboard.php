<?php
session_start(); // Must be first line
if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php"); // Redirect if not logged in
    exit();
}

include "db.php";
include "components/navbar.php";

// Query stats
$residents = $conn->query("SELECT COUNT(*) as total FROM residents")->fetch_assoc()['total'];
$cases = $conn->query("SELECT COUNT(*) as total FROM cases")->fetch_assoc()['total'];
$open_cases = $conn->query("SELECT COUNT(*) as total FROM cases WHERE status='Open'")->fetch_assoc()['total'];
$resolved_cases = $conn->query("SELECT COUNT(*) as total FROM cases WHERE status='Resolved'")->fetch_assoc()['total'];
$evidence = $conn->query("SELECT COUNT(*) as total FROM evidence")->fetch_assoc()['total'];
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
?>

<style>
:root{
    --primary:#3d5a80;
    --secondary:#98c1d9;
    --light:#e0fbfc;
    --accent:#ee6c4d;
    --dark:#293241;
}

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(135deg, var(--secondary), var(--light));
}

.dashboard-box {
    width: 200px;
    padding: 40px;
    background: #3498db;
    color: white;
    border-radius: 12px;
    display: inline-block;
    margin: 15px;
    font-size: 20px;
    text-align: center;
}
.dashboard-box.green { background: #27ae60; }
.dashboard-box.red { background: #e74c3c; }
.dashboard-box.orange { background: #e67e22; }
.dashboard-box.purple { background: #9b59b6; }
.dashboard-box.navy { background: #2c3e50; }
</style>

<div class="content">
<h1>📊 Dashboard</h1>
<p>Welcome, <strong><?= $_SESSION['username']; ?></strong>!</p>

<div class="dashboard-box navy">Residents <br><b><?= $residents ?></b></div>
<div class="dashboard-box orange">Cases <br><b><?= $cases ?></b></div>
<div class="dashboard-box green">Open Cases <br><b><?= $open_cases ?></b></div>
<div class="dashboard-box purple">Resolved Cases <br><b><?= $resolved_cases ?></b></div>
<div class="dashboard-box red">Evidence <br><b><?= $evidence ?></b></div>
<div class="dashboard-box" style="background:#8e44ad;">Users <br><b><?= $users ?></b></div>
</div>
