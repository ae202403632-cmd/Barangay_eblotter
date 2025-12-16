<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$first = $_POST['first_name'];
$last = $_POST['last_name'];
$gender = $_POST['gender'];
$birth = $_POST['birthdate'];
$address = $_POST['address'];
$contact = $_POST['contact_no'];

$sql = "INSERT INTO residents(first_name,last_name,gender,birthdate,address,contact_no)
        VALUES('$first','$last','$gender','$birth','$address','$contact')";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error: " . $conn->error;
}
?>
