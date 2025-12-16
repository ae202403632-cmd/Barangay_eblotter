<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include "../db.php";

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM cases WHERE case_id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: list.php");
    exit();
}

$case = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Case</title>
    <style>
        :root {
            --primary: #3d5a80;
            --secondary: #98c1d9;
            --light: #e0fbfc;
            --dark: #293241;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--secondary), var(--light));
        }

        .page-container {
            width: 100%;
            max-width: 520px;
            padding: 30px 15px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.18);
            padding: 32px 30px 28px;
        }

        .card h2 {
            text-align: center;
            margin-bottom: 26px;
            color: var(--dark);
            font-size: 24px;
            letter-spacing: 0.03em;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
        }

        .form-control,
        .form-select,
        textarea {
            width: 100%;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #cdd7e5;
            font-size: 14px;
            outline: none;
            transition: 0.15s ease;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(61, 90, 128, 0.18);
        }

        .btn-submit {
            width: 100%;
            margin-top: 6px;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease;
        }

        .btn-submit:hover {
            background: #2f4b6c;
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
            color: var(--primary);
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="page-container">
    <div class="card">
        <h2>Edit Case</h2>

        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($case['case_id']); ?>">

            <div class="form-group">
                <label>Case Title</label>
                <input
                    type="text"
                    name="case_title"
                    class="form-control"
                    value="<?php echo htmlspecialchars($case['case_title']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Case Details</label>
                <textarea
                    name="case_details"
                    class="form-control"
                    rows="4"
                    required
                ><?php echo htmlspecialchars($case['case_details']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Incident Date</label>
                <input
                    type="date"
                    name="incident_date"
                    class="form-control"
                    value="<?php echo htmlspecialchars($case['incident_date']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Incident Place</label>
                <input
                    type="text"
                    name="incident_place"
                    class="form-control"
                    value="<?php echo htmlspecialchars($case['incident_place']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="Open"     <?php if ($case['status'] === 'Open')     echo 'selected'; ?>>Open</option>
                    <option value="Ongoing"  <?php if ($case['status'] === 'Ongoing')  echo 'selected'; ?>>Ongoing</option>
                    <option value="Closed"   <?php if ($case['status'] === 'Closed')   echo 'selected'; ?>>Closed</option>
                    <option value="Resolved" <?php if ($case['status'] === 'Resolved') echo 'selected'; ?>>Resolved</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Update Case</button>
        </form>

        <a href="list.php" class="back-link">← Back</a>
    </div>
</div>

</body>
</html>