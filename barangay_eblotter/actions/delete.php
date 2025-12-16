<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }
include "navbar.php";

$id = $_GET['id'];

$sql = "DELETE FROM actions WHERE action_id=$id";

if ($conn->query($sql)) {
    header("Location: list.php");
} else {
    echo "Error Deleting: " . $conn->error;
}
?>
