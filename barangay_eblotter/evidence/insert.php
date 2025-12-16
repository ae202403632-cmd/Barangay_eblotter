<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$caseName    = $_POST['case_name'] ?? '';
$description = $_POST['description'] ?? '';
$file        = $_FILES['file'] ?? null;

if ($caseName && $file && $file['error']===UPLOAD_ERR_OK) {
    $caseStmt = $conn->prepare("SELECT case_id FROM cases WHERE case_title = ? LIMIT 1");
    $caseStmt->bind_param("s",$caseName);
    $caseStmt->execute();
    $caseRow = $caseStmt->get_result()->fetch_assoc();
    $case_id = $caseRow['case_id'] ?? null;

    if($case_id){
        $uploadDir="../uploads/evidence/";
        if(!is_dir($uploadDir)){mkdir($uploadDir,0777,true);}
        $origName = basename($file['name']);
        $safeName = time()."_".preg_replace("/[^A-Za-z0-9._-]/","_",$origName);
        $target   = $uploadDir.$safeName;

        if(move_uploaded_file($file['tmp_name'],$target)){
            $stmt=$conn->prepare(
                "INSERT INTO evidence (case_id,file_name,file_path,description,uploaded_at)
                 VALUES (?,?,?,?,NOW())"
            );
            $stmt->bind_param("isss",$case_id,$origName,$target,$description);
            if($stmt->execute()){
                header("Location: list.php?success=Uploaded+successfully");
                exit;
            } else {
                $msg="Database Error: ".$conn->error;
            }
        }else{
            $msg="File Upload Failed.";
        }
    }else{
        $msg="Case not found.";
    }
}else{
    $msg="Missing case or file.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Result</title>
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
    <h2 class="card-title-main">Upload Evidence</h2>
    <div class="alert alert-danger py-2 mb-3">
        <?= htmlspecialchars($msg) ?>
    </div>
    <a href="upload.php" class="back-link">← Back to Upload</a>
</div>
</body>
</html>

