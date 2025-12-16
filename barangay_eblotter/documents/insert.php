<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$case_id        = (int)($_POST['case_id'] ?? 0);
$document_title = $_POST['document_title'] ?? '';
$description    = $_POST['description'] ?? '';
$file           = $_FILES['file'] ?? null;

if($case_id>0 && $document_title!=='' && $file && $file['error']===UPLOAD_ERR_OK){
    $uploadDir = "../uploads/documents/";
    if(!is_dir($uploadDir)){mkdir($uploadDir,0777,true);}

    $origName = basename($file['name']);
    $safeName = time()."_".preg_replace("/[^A-Za-z0-9._-]/","_",$origName);
    $target   = $uploadDir.$safeName;

    if(move_uploaded_file($file['tmp_name'],$target)){
        $stmt=$conn->prepare(
            "INSERT INTO documents (case_id,document_title,file_name,file_path,description,uploaded_at)
             VALUES (?,?,?,?,?,NOW())"
        );
        $stmt->bind_param("issss",$case_id,$document_title,$origName,$target,$description);
        if($stmt->execute()){
            header("Location: list.php?success=Document+uploaded");
            exit;
        }else{
            $msg="Database Error: ".$conn->error;
        }
    }else{
        $msg="File upload failed.";
    }
}else{
    $msg="Please fill in all required fields.";
}
header("Location: add.php?error=".urlencode($msg));
exit;

