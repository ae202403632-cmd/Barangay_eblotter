<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_GET['id'];

$doc = $conn->query("SELECT file_path FROM documents WHERE document_id=$id")->fetch_assoc();

$file = "../uploads/" . $doc['file_path'];

if (file_exists($file)) {
    unlink($file);
}

$sql = "DELETE FROM documents WHERE document_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Delete Error: " . $conn->error;
}
?>
