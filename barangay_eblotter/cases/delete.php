<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_GET['id'];

$sql = "DELETE FROM cases WHERE case_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
