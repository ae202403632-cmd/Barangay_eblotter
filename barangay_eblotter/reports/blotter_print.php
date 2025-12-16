<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$sql = "
    SELECT
        c.case_id,
        c.case_title,
        c.case_details,
        c.incident_date,
        c.status,
        r.first_name,
        r.last_name,
        cp.role
    FROM cases c
    LEFT JOIN case_participants cp
        ON cp.case_id = c.case_id
    LEFT JOIN residents r
        ON cp.resident_id = r.resident_id
    ORDER BY c.case_id ASC
";


$result = $conn->query($sql);
if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Barangay Blotter Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        .print-btn {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Barangay Blotter Report</h1>
<p style="text-align:center;">Generated on <?php echo date("F d, Y"); ?></p>

<button class="print-btn" onclick="window.print()">Print</button>

<table>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Description</th>
        <th>Name</th>
        <th>Role</th>
        <th>Date Filed</th>
        <th>Status</th>

    </tr>

    <?php
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$i++."</td>"; // Auto numbering
        echo "<td>".$row['case_title']."</td>";
        echo "<td>".$row['case_details']."</td>";
        echo "<td>".$row['first_name']." ".$row['last_name']."</td>"; // Name
        echo "<td>".$row['role']."</td>"; // NEW ROLE COLUMN
        echo "<td>".$row['incident_date']."</td>";
        echo "<td>".$row['status']."</td>";
        echo "</tr>";
    }
    ?>

</table>

</body>
</html>
