<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); }
include "../db.php";

$result = $conn->query("SELECT * FROM cases ORDER BY case_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Cases</title>
<link rel="stylesheet" href="../assets/css/ui.css">

</head>
<body>

<div class="page-container">
<div class="page-header">
    <h1>Cases</h1>
    <a href="../dashboard.php" class="btn btn-back">← Dashboard</a>
</div>

<div class="card">
<div class="table-toolbar">
    <a href="create.php" class="btn btn-add">+ Add Case</a>
</div>

<div class="table-wrapper">
<table>
<thead>
<tr>
    <th>#</th>
    <th>Case Title</th>
    <th>Date</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php $i=1; while($row=$result->fetch_assoc()): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($row['case_title']) ?></td>
    <td><?= $row['incident_date'] ?></td>
    <td><?= $row['status'] ?></td>
    <td class="action">
        <a href="edit.php?id=<?= $row['case_id'] ?>" class="edit">Edit</a>
        <a href="delete.php?id=<?= $row['case_id'] ?>" class="delete">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
</div>

</body>
</html>
