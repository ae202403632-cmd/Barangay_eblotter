<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$case_id = $_POST['case_id'];
$resident_id = $_POST['resident_id'];
$role = $_POST['role'];
$statement = $_POST['statement'];

$sql = "INSERT INTO case_participants(case_id, resident_id, role, statement)
        VALUES('$case_id','$resident_id','$role','$statement')";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error: " . $conn->error;
}
?>
