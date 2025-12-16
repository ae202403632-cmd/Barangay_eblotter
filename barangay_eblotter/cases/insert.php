<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$title = $_POST['case_title'];
$details = $_POST['case_details'];
$date = $_POST['incident_date'];
$place = $_POST['incident_place'];
$status = $_POST['status'];

$sql = "INSERT INTO cases(case_title, case_details, incident_date, incident_place, status)
        VALUES('$title','$details','$date','$place','$status')";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error: " . $conn->error;
}
?>
