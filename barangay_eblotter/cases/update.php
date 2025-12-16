<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_POST['id'];
$title = $_POST['case_title'];
$details = $_POST['case_details'];
$date = $_POST['incident_date'];
$place = $_POST['incident_place'];
$status = $_POST['status'];

$sql = "UPDATE cases SET
        case_title='$title',
        case_details='$details',
        incident_date='$date',
        incident_place='$place',
        status='$status'
        WHERE case_id=$id";

if ($conn->query($sql)) {
        header("Location: list.php?updated=1");
} else {
    echo "Error: " . $conn->error;
}
?>
