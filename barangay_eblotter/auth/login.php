<?php
session_start();
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay eBlotter | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            min-height:100vh;margin:0;display:flex;justify-content:center;align-items:center;
            background:linear-gradient(135deg,#c5e5ff 0%,#e9f7ff 55%,#ffffff 100%);
            font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        }
        .login-wrapper{
            width:420px;background:#ffffff;border-radius:28px;
            box-shadow:0 24px 60px rgba(0,0,0,.15);
            padding:32px 34px 26px;
        }
        .brand-title{
            font-size:26px;font-weight:800;color:#123a5d;
            text-align:center;margin-bottom:4px;
        }
        .brand-sub{
            font-size:13px;text-align:center;color:#6b7a95;margin-bottom:24px;
        }
        .form-label{font-weight:600;font-size:14px;color:#344767;}
        .form-control{
            border-radius:11px;font-size:14px;
        }
        .btn-login{
            width:100%;border-radius:999px;
            background:#2f4f7f;border-color:#2f4f7f;
            font-weight:600;padding:10px 0;
        }
        .btn-login:hover{background:#243d60;border-color:#243d60;}
        .small-note{
            font-size:12px;color:#7c889f;text-align:center;margin-top:10px;
        }
        .footer-copy{
            position:fixed;bottom:12px;left:0;right:0;
            text-align:center;font-size:11px;color:#7c889f;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="text-center mb-2">
    </div>
    <h1 class="brand-title">Barangay eBlotter</h1>
    <p class="brand-sub">Secure portal for recording cases and incidents</p>

    <?php if($error): ?>
        <div class="alert alert-danger py-2 mb-3 text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="login_process.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" autocomplete="username" required>
        </div>

        <div class="mb-3">
            <label class="form-label d-flex justify-content-between align-items-center">
                <span>Password</span>
            </label>
            <input type="password" name="password" class="form-control" autocomplete="current-password" required>
        </div>

        <button type="submit" class="btn btn-login mt-1">Sign in</button>
    </form>

    <p class="small-note">Authorized personnel only. Your activity may be logged.</p>
</div>

<p class="footer-copy">© <?= date('Y') ?> Barangay eBlotter</p>

</body>
</html>
