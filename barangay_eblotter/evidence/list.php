<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$sql = "
    SELECT
        e.evidence_id,
        c.case_title,
        e.file_name,
        e.file_path,
        e.description,
        e.uploaded_at
    FROM evidence e
    JOIN cases c ON e.case_id = c.case_id
    ORDER BY e.evidence_id ASC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Evidence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 60px 40px;
            background: linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        }
        .page-title {
            font-size: 34px;
            font-weight: 800;
            color: #123a5d;
            margin-bottom: 26px;
        }
        .btn-dashboard {
            position: absolute;
            top: 30px;
            right: 50px;
            background-color: #123a5d;
            color: #fff;
            border-radius: 10px;
            padding: 9px 20px;
            border: none;
            font-weight: 600;
        }
        .card-shell {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.10);
            padding: 22px 24px 18px;
        }
        .btn-primary-soft {
            background-color: #204b78;
            border-color: #204b78;
            border-radius: 10px;
            padding: 9px 20px;
            font-weight: 600;
            color: #fff;
        }
        .btn-primary-soft:hover {
            background-color: #183757;
            border-color: #183757;
        }
        .custom-table {
            border-collapse: collapse;
        }
        .custom-table thead {
            background-color: #274c74;
            color: #ffffff;
        }
        .custom-table thead th {
            border: 2px solid #d0d8e5;
            font-weight: 600;
        }
        .custom-table tbody td,
        .custom-table tbody th {
            vertical-align: middle;
            border: 2px solid #d0d8e5;
            font-size: 14px;
        }
        .file-link {
            color: #1a5fb4;
            text-decoration: none;
        }
        .file-link:hover {
            text-decoration: underline;
        }
        .link-edit {
            color: #1a5fb4;
            font-weight: 500;
            margin-right: 8px;
            text-decoration: none;
        }
        .link-edit:hover {
            text-decoration: underline;
        }
        .link-delete {
            color: #d9534f;
            font-weight: 500;
            text-decoration: none;
        }
        .link-delete:hover {
            text-decoration: underline;
        }
        .back-link {
            display: inline-block;
            margin-top: 12px;
            font-size: 13px;
            color: #6b7a95;
            text-decoration: none;
        }
        .back-link:hover {
            color: #3b4a63;
        }
    </style>
</head>
<body>

<button class="btn-dashboard" onclick="window.location.href='../dashboard.php';">
    ← Dashboard
</button>

<h1 class="page-title">Evidence</h1>

<div class="card-shell">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button
            class="btn btn-primary-soft"
            onclick="window.location.href='upload.php';">
            Upload Evidence
        </button>
    </div>

    <div class="table-responsive">
        <table class="table custom-table mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Case</th>
                    <th>File Name</th>
                    <th>Description</th>
                    <th>Uploaded At</th>
                    <th style="width:160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $i = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo htmlspecialchars($row['case_title']); ?></td>
                            <td>
                                <?php if (!empty($row['file_path'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>"
                                       target="_blank"
                                       class="file-link">
                                        <?php echo htmlspecialchars($row['file_name']); ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($row['file_name']); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['uploaded_at']); ?></td>
                            <td>
                                <a
                                    href="edit.php?id=<?php echo $row['evidence_id']; ?>"
                                    class="link-edit">Edit</a>
                                <a
                                    href="delete.php?id=<?php echo $row['evidence_id']; ?>"
                                    class="link-delete"
                                    onclick="return confirm('Delete this evidence record?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No evidence records found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>