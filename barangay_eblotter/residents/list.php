<?php
session_start();

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

/* =========================
   DATABASE CONNECTION
========================= */
include "../db.php";

/* =========================
   RESIDENTS QUERY
========================= */
$sql = "SELECT resident_id, first_name, last_name, gender, birthdate, address, contact_no
        FROM residents
        ORDER BY resident_id ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Residents List</title>

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

/* PAGE */
.page-container{
    max-width:1100px;
    margin:60px auto;
    padding:20px;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h1{
    margin:0;
    color:var(--dark);
}

/* BUTTONS */
.btn{
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
}

.btn-add{
    background:var(--primary);
    color:white;
}

.btn-add:hover{
    background:#2f4b6c;
}

.btn-back{
    background:var(--dark);
    color:white;
}

/* CARD */
.card{
    background:white;
    border-radius:14px;
    padding:25px;
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

/* TABLE TOOLBAR */
.table-toolbar{
    margin-bottom:18px;
}

/* TABLE */
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    border:2px solid var(--primary);
}

thead{
    background:var(--primary);
    color:white;
}

th, td{
    padding:14px;
    border:1px solid var(--secondary);
    font-size:14px;
}

tbody tr:nth-child(even){
    background:#f7fbfd;
}

tbody tr:hover{
    background:var(--light);
}

/* ACTION LINKS */
.action a{
    margin-right:10px;
    font-weight:600;
    text-decoration:none;
}

.edit{
    color:var(--primary);
}

.delete{
    color:var(--accent);
}
</style>
</head>

<body>

<div class="page-container">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Residents</h1>
        <a href="../dashboard.php" class="btn btn-back">← Dashboard</a>
    </div>

    <!-- CARD -->
    <div class="card">

        <!-- ADD BUTTON -->
        <div class="table-toolbar">
            <a href="create.php" class="btn btn-add">+ Add Resident</a>
        </div>

        <!-- TABLE -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $count = 1;
                if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= htmlspecialchars($row['first_name'].' '.$row['last_name']); ?></td>
                        <td><?= htmlspecialchars($row['gender']); ?></td>
                        <td><?= htmlspecialchars($row['birthdate']); ?></td>
                        <td><?= htmlspecialchars($row['address']); ?></td>
                        <td><?= htmlspecialchars($row['contact_no']); ?></td>
                        <td class="action">
                            <a href="edit.php?id=<?= $row['resident_id']; ?>" class="edit">Edit</a>
                            <a href="delete.php?id=<?= $row['resident_id']; ?>" class="delete"
                               onclick="return confirm('Delete this resident?')">Delete</a>
                        </td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">No residents found</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

</body>
</html>
