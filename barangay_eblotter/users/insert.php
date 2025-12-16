<?php
$host="localhost";$user="root";$pass="";$db="barangay_eblotter";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("Connection failed: ".$conn->connect_error);}

$full_name = $_POST['full_name'] ?? '';
$username  = $_POST['username']  ?? '';
$password  = $_POST['password']  ?? '';
$role      = $_POST['role']      ?? '';

if($full_name!=='' && $username!=='' && $password!=='' && $role!==''){
    $hash = password_hash($password,PASSWORD_BCRYPT);
    $stmt = $conn->prepare(
        "INSERT INTO users (username,password,full_name,role,created_at)
         VALUES (?,?,?,?,NOW())"
    );
    $stmt->bind_param("ssss",$username,$hash,$full_name,$role);
    if($stmt->execute()){
        header("Location: list.php?success=User+added");
        exit;
    }else{
        $msg="Database Error: ".$conn->error;
    }
}else{
    $msg="Please fill in all required fields.";
}
header("Location: add.php?error=".urlencode($msg));
exit;
