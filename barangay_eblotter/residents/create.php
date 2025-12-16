<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add New Resident</title>

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

/* PAGE CENTER */
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

/* FORM GROUP */
.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:var(--dark);
}

/* INPUTS */
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
        <h2>Add New Resident</h2>

        <form action="insert.php" method="POST">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">Select gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Birthdate</label>
                <input type="date" name="birthdate"
                       min="1900-01-01"
                       max="<?= date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-group">
                <label>Contact No.</label>
                <input type="text" name="contact_no" required>
            </div>

            <button type="submit" class="btn btn-save">Save Resident</button>
        </form>

        <a href="list.php" class="back-link">← Back to Residents</a>
    </div>

</div>

</body>
</html>
