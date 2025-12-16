<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "barangay_eblotter";

$conn = new mysqli($host,$user,$pass,$db);
if ($conn->connect_error) { die("Connection failed: ".$conn->connect_error); }

$sql = "
    SELECT
        a.action_id,
        c.case_title,
        a.action_type,
        a.action_details,
        a.action_date,
        a.created_at
    FROM actions a
    JOIN cases c ON a.case_id = c.case_id
    ORDER BY a.action_date DESC, a.action_id ASC
";
$result = $conn->query($sql);

$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Case Actions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            min-height:100vh;margin:0;padding:60px 40px;
            background:linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        }
        .btn-dashboard{
            position:absolute;top:30px;right:50px;
            background:#123a5d;color:#fff;border-radius:10px;
            padding:9px 20px;border:none;font-weight:600;
        }
        .page-title{font-size:34px;font-weight:800;color:#123a5d;margin-bottom:26px;}
        .card-shell{
            background:#fff;border-radius:24px;
            box-shadow:0 18px 40px rgba(0,0,0,.1);
            padding:22px 24px 18px;
        }
        .btn-primary-soft{
            background:#204b78;border-color:#204b78;
            border-radius:10px;padding:9px 20px;font-weight:600;color:#fff;
        }
        .btn-primary-soft:hover{background:#183757;border-color:#183757;}
        .custom-table{border-collapse:collapse;}
        .custom-table thead{background:#274c74;color:#fff;}
        .custom-table thead th{border:2px solid #d0d8e5;font-weight:600;}
        .custom-table tbody td,.custom-table tbody th{
            vertical-align:middle;border:2px solid #d0d8e5;font-size:14px;
        }
        .link-edit{color:#1a5fb4;font-weight:500;text-decoration:none;margin-right:8px;}
        .link-edit:hover{text-decoration:underline;}
        .link-delete{color:#d9534f;font-weight:500;text-decoration:none;}
        .link-delete:hover{text-decoration:underline;}
        .back-link{display:inline-block;margin-top:12px;font-size:13px;color:#6b7a95;text-decoration:none;}
        .back-link:hover{color:#3b4a63;}
    </style>
</head>
<body>

<button class="btn-dashboard" onclick="window.location.href='../dashboard.php';">← Dashboard</button>

<h1 class="page-title">Case Actions</h1>

<div class="card-shell">
    <?php if ($success): ?>
        <div class="alert alert-success py-2 mb-3">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary-soft" onclick="window.location.href='add.php';">
            Add Action
        </button>
    </div>

    <div class="table-responsive">
        <table class="table custom-table mb-0">
            <thead>
            <tr>
                <th style="width:60px;">#</th>
                <th>Case</th>
                <th>Type</th>
                <th>Details</th>
                <th>Action Date</th>
                <th style="width:160px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php $i=1; while($row=$result->fetch_assoc()): ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= htmlspecialchars($row['case_title']) ?></td>
                        <td><?= htmlspecialchars($row['action_type']) ?></td>
                        <td><?= htmlspecialchars($row['action_details']) ?></td>
                        <td><?= htmlspecialchars($row['action_date']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['action_id'] ?>" class="link-edit">Edit</a>
                            <a href="delete.php?id=<?= $row['action_id'] ?>"
                               class="link-delete"
                               onclick="return confirm('Delete this action?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted">No actions found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
