<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }
include "navbar.php";

$id = $_POST['action_id'];
$case_id = $_POST['case_id'];
$action_type = $_POST['action_type'];
$action_details = $_POST['action_details'];
$action_date = $_POST['action_date'];

$sql = "UPDATE actions SET
        case_id='$case_id',
        action_type='$action_type',
        action_details='$action_details',
        action_date='$action_date'
        WHERE action_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Update Error: " . $conn->error;
}
?>
