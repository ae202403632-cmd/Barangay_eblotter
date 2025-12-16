<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }
include "../db.php";

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE user_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Delete Error: " . $conn->error;
}
?>
