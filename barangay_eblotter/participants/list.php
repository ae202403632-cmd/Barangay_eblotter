<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$sql = "SELECT cp.*, r.first_name, r.last_name, c.case_title
        FROM case_participants cp
        LEFT JOIN residents r ON cp.resident_id = r.resident_id
        LEFT JOIN cases c ON cp.case_id = c.case_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Case Participants</title>
    <link rel="stylesheet" href="../assets/css/ui.css">
</head>
<body>
<div class="page-container">

    <div class="page-header">
        <h1>Case Participants</h1>
        <a href="../dashboard.php" class="btn btn-back">Dashboard</a>
    </div>

    <div class="card">
        <div class="table-toolbar">
            <a href="create.php" class="btn btn-add">Add Participant</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Case</th>
                        <th>Resident</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['case_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td class="action">
                            <a href="edit.php?id=<?php echo $row['participant_id']; ?>" class="edit">Edit</a>
                            <a href="delete.php?id=<?php echo $row['participant_id']; ?>" class="delete"
                               onclick="return confirm('Delete participant?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
</body>
</html>