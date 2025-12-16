<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include "../db.php";

/* GET ID */
if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH RESIDENT */
$sql = "SELECT * FROM residents WHERE resident_id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: list.php");
    exit();
}

$resident = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Resident</title>

<style>
:root{
    --primary:#3d5a80;
    --secondary:#98c1d9;
    --light:#e0fbfc;
    --accent:#ee6c4d;
    --dark:#293241;
}

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(135deg, var(--secondary), var(--light));
}

/* CENTER PAGE */
.page-container{
    max-width:500px;
    margin:70px auto;
    padding:20px;
}

/* CARD */
.card{
    background:white;
    border-radius:16px;
    padding:30px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

/* HEADER */
.card h2{
    margin-top:0;
    margin-bottom:25px;
    color:var(--dark);
    text-align:center;
}

/* FORM */
.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:var(--dark);
}

input, select{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid var(--secondary);
    font-size:14px;
    outline:none;
}

input:focus, select:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 2px rgba(61,90,128,0.2);
}

/* BUTTONS */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
}

.btn-save{
    background:var(--primary);
    color:white;
    margin-top:10px;
}

.btn-save:hover{
    background:#2f4b6c;
}

/* BACK LINK */
.back-link{
    display:block;
    text-align:center;
    margin-top:18px;
    text-decoration:none;
    color:var(--primary);
    font-weight:600;
}
</style>
</head>

<body>

<div class="page-container">

    <div class="card">
        <h2>Edit Resident</h2>

        <form action="update.php" method="POST">

            <input type="hidden" name="resident_id" value="<?= $resident['resident_id']; ?>">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" 
                       value="<?= htmlspecialchars($resident['first_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" 
                       value="<?= htmlspecialchars($resident['last_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">Select gender</option>
                    <option <?= $resident['gender']=='Male'?'selected':'' ?>>Male</option>
                    <option <?= $resident['gender']=='Female'?'selected':'' ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Birthdate</label>
                <input type="date" name="birthdate"
                       value="<?= $resident['birthdate']; ?>"
                       min="1900-01-01"
                       max="<?= date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" 
                       value="<?= htmlspecialchars($resident['address']); ?>" required>
            </div>

            <div class="form-group">
                <label>Contact No.</label>
                <input type="text" name="contact_no" 
                       value="<?= htmlspecialchars($resident['contact_no']); ?>" required>
            </div>

            <button type="submit" class="btn btn-save">Update Resident</button>
        </form>

        <a href="list.php" class="back-link">← Back to Residents</a>
    </div>

</div>

</body>
</html>
