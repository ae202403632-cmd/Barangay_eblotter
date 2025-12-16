<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$id = (int)($_GET['id'] ?? 0);
if($id<=0){die("Invalid ID");}

$u = $conn->query("SELECT * FROM users WHERE user_id=$id")->fetch_assoc();
if(!$u){die("User not found");}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{min-height:100vh;margin:0;display:flex;justify-content:center;align-items:center;
            background:linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;}
        .card-shell{width:480px;background:#fff;border-radius:26px;box-shadow:0 24px 60px rgba(0,0,0,.12);padding:32px 32px 26px;}
        .card-title-main{font-size:24px;font-weight:700;text-align:center;margin-bottom:24px;color:#1c3553;}
        .form-label{font-weight:600;font-size:14px;color:#344767;}
        .form-control,.form-select{border-radius:10px;font-size:14px;}
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
    <h2 class="card-title-main">Edit User</h2>

    <?php if($error): ?><div class="alert alert-danger py-2 mb-3"><?= htmlspecialchars($error) ?></div><?php endif;?>

    <form action="update.php" method="POST">
        <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">

        <div class="mb-3">
            <label class="form-label">Full Name:</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($u['full_name']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($u['username']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password (leave blank to keep current):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label">Role:</label>
            <select name="role" class="form-select" required>
                <?php
                $roles = ["Admin","Staff","Captain"];
                foreach($roles as $r):
                ?>
                    <option value="<?= $r ?>" <?= $r==($u['role'] ?? '')?'selected':'' ?>><?= $r ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary-full">Update</button>
        <a href="list.php" class="back-link">← Back</a>
    </form>
</div>

</body>
</html>
