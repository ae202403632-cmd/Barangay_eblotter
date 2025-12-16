<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_POST['resolution_id'];
$case_id = $_POST['case_id'];
$status = $_POST['status'];
$text = $_POST['resolution_text'];
$date = $_POST['resolution_date'];

$sql = "UPDATE resolution SET
        case_id='$case_id',
        status='$status',
        resolution_text='$text',
        resolution_date='$date'
        WHERE resolution_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error updating: " . $conn->error;
}
?>
