<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$id          = (int)($_POST['evidence_id'] ?? 0);
$case_id     = (int)($_POST['case_id'] ?? 0);
$description = $_POST['description'] ?? '';

if($id>0 && $case_id>0){
    $sql = "UPDATE evidence
            SET case_id=$case_id, description='".$conn->real_escape_string($description)."'
            WHERE evidence_id=$id";
    if($conn->query($sql)){
        header("Location: list.php?success=Updated");
        exit;
    }else{
        $msg="Error updating record: ".$conn->error;
    }
}else{
    $msg="Invalid data.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Evidence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{min-height:100vh;margin:0;display:flex;justify-content:center;align-items:center;
            background:linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;}
        .card-shell{width:420px;background:#fff;border-radius:26px;box-shadow:0 24px 60px rgba(0,0,0,.12);padding:32px;}
        .card-title-main{font-size:22px;font-weight:700;text-align:center;margin-bottom:16px;color:#1c3553;}
        .back-link{display:block;text-align:center;margin-top:12px;font-size:13px;color:#6b7a95;text-decoration:none;}
        .back-link:hover{color:#3b4a63;}
    </style>
</head>
<body>
<div class="card-shell">
    <h2 class="card-title-main">Update Evidence</h2>
    <div class="alert alert-danger py-2 mb-3">
        <?= htmlspecialchars($msg) ?>
    </div>
    <a href="list.php" class="back-link">← Back to Evidence</a>
</div>
</body>
</html>
