<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login - AmbuCall</title>
</head>
<body class="auth-page">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="fas fa-heartbeat fa-3x text-danger mb-2"></i>
                <h3 class="fw-bold">AMBU-CALL</h3>
                <form action="proses_login.php" method="POST" class="mt-4 text-start">
                    <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                    <button type="submit" class="btn btn-danger w-100"><i class="fas fa-sign-in-alt me-2"></i>Masuk</button>
                </form>
                <p class="mt-3 small">Belum punya akun? <a href="register.php" class="text-danger">Daftar</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>