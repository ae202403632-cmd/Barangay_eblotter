<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$cases     = $conn->query("SELECT * FROM cases");
$residents = $conn->query("SELECT * FROM residents");


// --- HANDLE FORM SUBMIT ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $caseName     = trim($_POST['case_name'] ?? '');
    $residentName = trim($_POST['resident_name'] ?? '');
    $role         = trim($_POST['role'] ?? '');
    $statement    = trim($_POST['statement'] ?? '');

    if ($caseName === '' || $residentName === '' || $role === '') {
        $error = "Please complete all required fields.";
    } else {
        // Find case_id by case_title (from table `cases`)
        $caseStmt = $conn->prepare(
            "SELECT case_id FROM cases WHERE case_title = ? LIMIT 1"
        );
        $caseStmt->bind_param("s", $caseName);
        $caseStmt->execute();
        $caseRow = $caseStmt->get_result()->fetch_assoc();
        $case_id = $caseRow['case_id'] ?? null;

        // Find resident_id by full name (from table `residents`)
        $resStmt = $conn->prepare(
            "SELECT resident_id FROM residents
             WHERE CONCAT(first_name,' ',last_name) = ? LIMIT 1"
        );
        $resStmt->bind_param("s", $residentName);
        $resStmt->execute();
        $resRow = $resStmt->get_result()->fetch_assoc();
        $resident_id = $resRow['resident_id'] ?? null;

        if ($case_id && $resident_id) {
            // Insert into table `case_participants`
            $ins = $conn->prepare(
                "INSERT INTO case_participants
                 (case_id, resident_id, role, statement)
                 VALUES (?,?,?,?)"
            );
            $ins->bind_param("iiss", $case_id, $resident_id, $role, $statement);
            if ($ins->execute()) {
                header("Location: list.php");  // or wherever your list page is
                exit;
            } else {
                $error = "Failed to save participant: " . $conn->error;
            }
        } else {
            $error = "Case or resident not found in the database. Please pick from the suggestions.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Case Participant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        }
        .card-shell {
            width: 420px;
            background: #ffffff;
            border-radius: 26px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.12);
            padding: 32px 32px 26px;
        }
        .card-title-main {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 24px;
            color: #1c3553;
        }
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #344767;
        }
        .form-select,
        .form-control,
        textarea.form-control {
            border-radius: 10px;
            font-size: 14px;
        }
        .btn-primary-full {
            width: 100%;
            border-radius: 999px;
            background-color: #2f4f7f;
            border-color: #2f4f7f;
            font-weight: 600;
            padding: 10px 0;
        }
        .btn-primary-full:hover {
            background-color: #243d60;
            border-color: #243d60;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 13px;
            color: #6b7a95;
            text-decoration: none;
        }
        .back-link:hover {
            color: #3b4a63;
        }
    </style>
</head>
<body>

<div class="card-shell">
    <h2 class="card-title-main">Add Case Participant</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 mb-3"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- Case (typeable, with suggestions) -->
        <div class="mb-3">
            <label for="caseInput" class="form-label">Case:</label>
            <input
                type="text"
                class="form-select"
                id="caseInput"
                name="case_name"
                list="caseOptions"
                placeholder="Select or type a case"
                required
            >
            <datalist id="caseOptions">
                <?php if ($cases): ?>
                    <?php while ($c = $cases->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($c['case_title']); ?>"></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </datalist>
        </div>

        <!-- Resident (typeable, with suggestions) -->
        <div class="mb-3">
            <label for="residentInput" class="form-label">Resident:</label>
            <input
                type="text"
                class="form-select"
                id="residentInput"
                name="resident_name"
                list="residentOptions"
                placeholder="Select or type a resident"
                required
            >
            <datalist id="residentOptions">
                <?php if ($residents): ?>
                    <?php while ($r = $residents->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($r['first_name'] . ' ' . $r['last_name']); ?>"></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </datalist>
        </div>

        <!-- Role (normal select) -->
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select name="role" id="role" class="form-select" required>
                <option value="Complainant">Complainant</option>
                <option value="Defendant">Defendant</option>
                <option value="Witness">Witness</option>
            </select>
        </div>

        <!-- Statement -->
        <div class="mb-4">
            <label for="statement" class="form-label">Statement:</label>
            <textarea
                name="statement"
                id="statement"
                rows="4"
                class="form-control"
                placeholder="Write the participant's statement here"
            ></textarea>
        </div>

        <button type="submit" class="btn btn-primary-full">Save</button>
        <a href="list.php" class="back-link">← Back</a>
    </form>
</div>

</body>
</html>