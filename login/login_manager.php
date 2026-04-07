<?php
session_start();
if(isset($_SESSION['manager_auth'])) { header("Location: manager_dashboard.php"); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Manager | AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .login-box { width: 400px; background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid #ff0000; }
        .btn-primary { background: #ff0000; border: none; padding: 10px; }
    </style>
</head>
<body>

<div class="login-box text-center">
    <h3 class="fw-bold text-danger mb-3"><i class="fas fa-user-shield me-2"></i> MANAGER PANEL</h3>
    <p class="text-muted mb-4">Silakan masuk untuk akses laporan</p>
    
    <form action="proses_login_manager.php" method="POST">
        <div class="mb-3 text-start">
            <label class="form-label small fw-bold">USERNAME</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="user_man" class="form-control" placeholder="Username" required>
            </div>
        </div>
        <div class="mb-4 text-start">
            <label class="form-label small fw-bold">PASSWORD</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="pass_man" class="form-control" placeholder="Password" required>
            </div>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 fw-bold shadow-sm">MASUK SEKARANG</button>
    </form>
    
    <div class="mt-4">
        <a href="index.php" class="text-decoration-none text-muted small">← Kembali ke Landing Page</a>
    </div>
</div>

</body>
</html>