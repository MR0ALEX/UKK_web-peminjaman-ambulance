<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user_pet']);
    $password = mysqli_real_escape_string($conn, $_POST['pass_pet']);
    
    $query = "SELECT * FROM petugas_akun WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $petugas = mysqli_fetch_assoc($result);
        
        $_SESSION['petugas_auth'] = true;
        $_SESSION['petugas_id'] = $petugas['id'];
        $_SESSION['petugas_nama'] = $petugas['nama_petugas'];
        $_SESSION['petugas_username'] = $petugas['username'];
        $_SESSION['petugas_unit'] = $petugas['id_unit'];
        $_SESSION['petugas_status'] = $petugas['status_tugas'];
        
        header("Location: petugas_dashboard.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Petugas | AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #2c3e50; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 350px; border-radius: 15px; border-top: 5px solid #e74c3c; }
    </style>
</head>
<body>
<div class="card login-card shadow p-4">
    <h4 class="text-center fw-bold mb-4">PETUGAS LOGIN</h4>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <form action="" method="POST">
        <div class="mb-3">
            <label class="small fw-bold">USERNAME</label>
            <input type="text" name="user_pet" class="form-control" required>
        </div>
        <div class="mb-4">
            <label class="small fw-bold">PASSWORD</label>
            <input type="password" name="pass_pet" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-danger w-100 fw-bold">MASUK TUGAS</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>