<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$case_id         = (int)($_POST['case_id'] ?? 0);
$resolution_text = $_POST['resolution_text'] ?? '';
$status          = $_POST['status'] ?? '';
$resolution_date = $_POST['resolution_date'] ?? '';

if($case_id>0 && $resolution_text!=='' && $status!=='' && $resolution_date!==''){
    $stmt = $conn->prepare(
        "INSERT INTO resolution (case_id,resolution_text,status,resolution_date,created_at)
         VALUES (?,?,?,?,NOW())"
    );
    $stmt->bind_param("isss",$case_id,$resolution_text,$status,$resolution_date);
    if($stmt->execute()){
        header("Location: list.php?success=Resolution+added");
        exit;
    }else{
        $msg="Database Error: ".$conn->error;
    }
}else{
    $msg="Please fill in all required fields.";
}
header("Location: add.php?error=".urlencode($msg));
exit;
