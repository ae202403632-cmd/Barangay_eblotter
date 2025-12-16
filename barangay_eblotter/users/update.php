<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$id        = (int)($_POST['user_id'] ?? 0);
$full_name = $_POST['full_name'] ?? '';
$username  = $_POST['username']  ?? '';
$password  = $_POST['password']  ?? '';
$role      = $_POST['role']      ?? '';

if($id>0 && $full_name!=='' && $username!=='' && $role!==''){
    if($password!==''){
        $hash = password_hash($password,PASSWORD_BCRYPT);
        $stmt = $conn->prepare(
            "UPDATE users SET full_name=?, username=?, password=?, role=? WHERE user_id=?"
        );
        $stmt->bind_param("ssssi",$full_name,$username,$hash,$role,$id);
    }else{
        $stmt = $conn->prepare(
            "UPDATE users SET full_name=?, username=?, role=? WHERE user_id=?"
        );
        $stmt->bind_param("sssi",$full_name,$username,$role,$id);
    }

    if($stmt->execute()){
        header("Location: list.php?success=User+updated");
        exit;
    }else{
        $msg="Error updating record: ".$conn->error;
    }
}else{
    $msg="Invalid data.";
}
header("Location: edit.php?id=".$id."&error=".urlencode($msg));
exit;
