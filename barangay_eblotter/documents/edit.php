<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$id = (int)($_GET['id'] ?? 0);
if($id<=0){die("Invalid ID");}

$d = $conn->query("SELECT * FROM documents WHERE document_id=$id")->fetch_assoc();
if(!$d){die("Document not found");}

$cases = $conn->query("SELECT * FROM cases");
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{min-height:100vh;margin:0;display:flex;justify-content:center;align-items:center;
            background:linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;}
        .card-shell{width:520px;background:#fff;border-radius:26px;box-shadow:0 24px 60px rgba(0,0,0,.12);padding:32px 32px 26px;}
        .card-title-main{font-size:24px;font-weight:700;text-align:center;margin-bottom:24px;color:#1c3553;}
        .form-label{font-weight:600;font-size:14px;color:#344767;}
        .form-select,.form-control{border-radius:10px;font-size:14px;}
        .btn-primary-full{width:100%;border-radius:999px;background:#2f4f7f;border-color:#2f4f7f;font-weight:600;padding:10px 0;}
        .btn-primary-full:hover{background:#243d60;border-color:#243d60;}
        .btn-dashboard{position:absolute;top:30px;right:50px;background:#123a5d;color:#fff;border-radius:10px;padding:9px 20px;border:none;font-weight:600;}
        .back-link{display:block;text-align:center;margin-top:10px;font-size:13px;color:#6b7a95;text-decoration:none;}
        .back-link:hover{color:#3b4a63;}
    </style>
</head>
<body>

<button class="btn-dashboard" onclick="window.location.href='../dashboard.php';">← Dashboard</button>

<div class="card-shell">
    <h2 class="card-title-main">Edit Document</h2>

    <?php if($error): ?><div class="alert alert-danger py-2 mb-3"><?= htmlspecialchars($error) ?></div><?php endif;?>

    <form action="update.php" method="POST">
        <input type="hidden" name="document_id" value="<?= $d['document_id'] ?>">

        <div class="mb-3">
            <label class="form-label">Case:</label>
            <select name="case_id" class="form-select" required>
                <?php while($c=$cases->fetch_assoc()): ?>
                    <option value="<?= $c['case_id'] ?>"
                        <?= $c['case_id']==$d['case_id']?'selected':'' ?>>
                        <?= htmlspecialchars($c['case_title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Document Title:</label>
            <input type="text" name="document_title" value="<?= htmlspecialchars($d['document_title']) ?>" class="form-control" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Description:</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($d['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary-full">Update</button>
        <a href="list.php" class="back-link">← Back</a>
    </form>
</div>

</body>
</html>
