<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_POST['id'];
$case_id = $_POST['case_id'];
$resident_id = $_POST['resident_id'];
$role = $_POST['role'];
$statement = $_POST['statement'];

$sql = "UPDATE case_participants SET
        case_id='$case_id',
        resident_id='$resident_id',
        role='$role',
        statement='$statement'
        WHERE participant_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error updating record: " . $conn->error;
}
?>
