<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_GET['id'];

$rec = $conn->query("SELECT file_path FROM evidence WHERE evidence_id=$id")->fetch_assoc();
$file = "../uploads/" . $rec['file_path'];

if (file_exists($file)) {
    unlink($file); // delete the file
}

$sql = "DELETE FROM evidence WHERE evidence_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error deleting: " . $conn->error;
}
?>
