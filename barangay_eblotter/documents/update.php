<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$id             = (int)($_POST['document_id'] ?? 0);
$case_id        = (int)($_POST['case_id'] ?? 0);
$document_title = $_POST['document_title'] ?? '';
$description    = $_POST['description'] ?? '';

if($id>0 && $case_id>0 && $document_title!==''){
    $stmt=$conn->prepare(
        "UPDATE documents
         SET case_id=?, document_title=?, description=?
         WHERE document_id=?"
    );
    $stmt->bind_param("issi",$case_id,$document_title,$description,$id);
    if($stmt->execute()){
        header("Location: list.php?success=Document+updated");
        exit;
    }else{
        $msg="Error updating record: ".$conn->error;
    }
}else{
    $msg="Invalid data.";
}
header("Location: edit.php?id=".$id."&error=".urlencode($msg));
exit;
