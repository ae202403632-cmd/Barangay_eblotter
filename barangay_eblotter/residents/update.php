<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include "../db.php";

/* =========================
   CHECK IF FORM SUBMITTED
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // GET DATA
    $id = intval($_POST['resident_id']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];
    $contact = $_POST['contact_no'];

    /* =========================
       UPDATE QUERY
    ========================= */
    $sql = "UPDATE residents SET
                first_name = '$first_name',
                last_name = '$last_name',
                gender = '$gender',
                birthdate = '$birthdate',
                address = '$address',
                contact_no = '$contact'
            WHERE resident_id = $id";

    if ($conn->query($sql) === TRUE) {
        // SUCCESS → BACK TO LIST
        header("Location: list.php?updated=1");
        exit();
    } else {
        // SHOW ERROR (VERY IMPORTANT FOR DEBUGGING)
        echo "Error updating record: " . $conn->error;
    }

} else {
    header("Location: list.php");
    exit();
}
?>
