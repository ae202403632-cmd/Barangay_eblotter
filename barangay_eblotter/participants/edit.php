<?php
include "../db.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); }

$id = $_GET['id'];

// Get specific participant
$record = $conn->query("SELECT * FROM case_participants WHERE participant_id=$id")->fetch_assoc();

// Get lists
$cases = $conn->query("SELECT * FROM cases");
$residents = $conn->query("SELECT * FROM residents");


$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid participant id.");
}

$participantStmt = $conn->prepare(
    "SELECT cp.*, c.case_title,
            CONCAT(r.first_name,' ',r.last_name) AS resident_fullname
     FROM case_participants cp
     JOIN cases c ON cp.case_id = c.case_id
     JOIN residents r ON cp.resident_id = r.resident_id
     WHERE cp.participant_id = ?"
);
$participantStmt->bind_param("i", $id);
$participantStmt->execute();
$participant = $participantStmt->get_result()->fetch_assoc();
if (!$participant) {
    die("Participant not found.");
}

// -------- HANDLE UPDATE SUBMIT --------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $caseName     = trim($_POST['case_name'] ?? '');
    $residentName = trim($_POST['resident_name'] ?? '');
    $role         = trim($_POST['role'] ?? '');
    $statement    = trim($_POST['statement'] ?? '');

    if ($caseName === '' || $residentName === '' || $role === '') {
        $error = "Please complete all required fields.";
    } else {
        // find case_id
        $caseStmt = $conn->prepare(
            "SELECT case_id FROM cases WHERE case_title = ? LIMIT 1"
        );
        $caseStmt->bind_param("s", $caseName);
        $caseStmt->execute();
        $caseRow = $caseStmt->get_result()->fetch_assoc();
        $case_id = $caseRow['case_id'] ?? null;

        // find resident_id
        $resStmt = $conn->prepare(
            "SELECT resident_id FROM residents
             WHERE CONCAT(first_name,' ',last_name) = ? LIMIT 1"
        );
        $resStmt->bind_param("s", $residentName);
        $resStmt->execute();
        $resRow = $resStmt->get_result()->fetch_assoc();
        $resident_id = $resRow['resident_id'] ?? null;

        if ($case_id && $resident_id) {
            $upd = $conn->prepare(
                "UPDATE case_participants
                 SET case_id = ?, resident_id = ?, role = ?, statement = ?
                 WHERE participant_id = ?"
            );
            $upd->bind_param("iissi", $case_id, $resident_id, $role, $statement, $id);
            if ($upd->execute()) {
                header("Location: list.php");
                exit;
            } else {
                $error = "Failed to update participant: " . $conn->error;
            }
        } else {
            $error = "Case or resident not found. Please choose from the suggestions.";
        }
    }

    // refresh $participant data for redisplay after validation errors
    $participant['case_title']       = $caseName;
    $participant['resident_fullname']= $residentName;
    $participant['role']             = $role;
    $participant['statement']        = $statement;
}

// -------- LOAD DATA FOR DATALISTS --------
$cases     = $conn->query("SELECT * FROM cases");
$residents = $conn->query("SELECT * FROM residents");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Case Participant</title>
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
        .form-control {
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
    <h2 class="card-title-main">Edit Case Participant</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 mb-3">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <!-- Case -->
        <div class="mb-3">
            <label for="caseInput" class="form-label">Case:</label>
            <input
                type="text"
                class="form-select"
                id="caseInput"
                name="case_name"
                list="caseOptions"
                placeholder="Select or type a case"
                value="<?php echo htmlspecialchars($participant['case_title']); ?>"
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

        <!-- Resident -->
        <div class="mb-3">
            <label for="residentInput" class="form-label">Resident:</label>
            <input
                type="text"
                class="form-select"
                id="residentInput"
                name="resident_name"
                list="residentOptions"
                placeholder="Select or type a resident"
                value="<?php echo htmlspecialchars($participant['resident_fullname']); ?>"
                required
            >
            <datalist id="residentOptions">
                <?php if ($residents): ?>
                    <?php while ($r = $residents->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($r['first_name'].' '.$r['last_name']); ?>"></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </datalist>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <?php $selectedRole = $participant['role']; ?>
            <select name="role" id="role" class="form-select" required>
                <option value="Complainant" <?php echo $selectedRole === 'Complainant' ? 'selected' : ''; ?>>Complainant</option>
                <option value="Respondent"  <?php echo $selectedRole === 'Respondent'  ? 'selected' : ''; ?>>Respondent</option>
                <option value="Witness"     <?php echo $selectedRole === 'Witness'     ? 'selected' : ''; ?>>Witness</option>
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
            ><?php echo htmlspecialchars($participant['statement']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary-full">Update</button>
        <a href="list.php" class="back-link">← Back</a>
    </form>
</div>

</body>
</html>