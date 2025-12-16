<?php
?>

<style>
    .sidebar {
        width: 230px;
        height: 100vh;
        background: #2c3e50;
        color: white;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
    }
    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .sidebar a {
        display: block;
        padding: 12px;
        margin-bottom: 8px;
        color: white;
        text-decoration: none;
        background: #34495e;
        border-radius: 5px;
    }
    .sidebar a:hover {
        background: #1abc9c;
    }
    .content {
        margin-left: 260px;
        padding: 30px;
    }
</style>

<div class="sidebar">
    <h2>E-Blotter</h2>

<a href="/barangay_eblotter/dashboard.php">🏠 Dashboard</a>
<a href="/barangay_eblotter/residents/list.php">👥 Residents</a>
<a href="/barangay_eblotter/cases/list.php">📑 Cases</a>
<a href="/barangay_eblotter/participants/list.php">🧍 Participants</a>
<a href="/barangay_eblotter/evidence/list.php">📸 Evidence</a>
<a href="/barangay_eblotter/actions/list.php">📝 Actions</a>
<a href="/barangay_eblotter/resolution/list.php">✔ Resolutions</a>
<a href="/barangay_eblotter/documents/list.php">📂 Documents</a>
<a href="/barangay_eblotter/users/list.php">👤 User Accounts</a>
<hr>
<a href="/barangay_eblotter/reports/blotter_print.php" target="_blank">🖨 Print Blotter Report</a>
<a href="/barangay_eblotter/auth/logout.php" style="background:#e74c3c;">🚪 Logout</a>

</div>
