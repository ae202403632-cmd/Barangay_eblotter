<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }
include "navbar.php";

$case_id = $_POST['case_id'];
$action_type = $_POST['action_type'];
$action_details = $_POST['action_details'];
$action_date = $_POST['action_date'];

$sql = "INSERT INTO actions(case_id, action_type, action_details, action_date)
        VALUES('$case_id', '$action_type', '$action_details', '$action_date')";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Insert Error: " . $conn->error;
}
?>
