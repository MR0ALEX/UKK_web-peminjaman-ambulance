<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Daftar Akun</title>
</head>
<body class="auth-page">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 card p-4">
            <h4 class="text-center fw-bold mb-4">Daftar Akun Penyewa</h4>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="u" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="p" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="reg" class="btn btn-danger w-100">Daftar Sekarang</button>
            </form>
            <p class="text-center mt-3 small">Sudah punya akun? <a href="index.php" class="text-danger">Login</a></p>
        </div>
    </div>
</div>

<?php
if(isset($_POST['reg'])){
    $u = mysqli_real_escape_string($conn, $_POST['u']);
    $p = $_POST['p'];
    
    $query = mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$u', '$p', 'user')");
    
    if($query){
        echo "<script>alert('Pendaftaran Berhasil!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal daftar!');</script>";
    }
}
?>
</body>
</html>