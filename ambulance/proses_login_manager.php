<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $u = mysqli_real_escape_string($conn, $_POST['user_man']);
    $p = mysqli_real_escape_string($conn, $_POST['pass_man']);

    $query = mysqli_query($conn, "SELECT * FROM manager_akun WHERE username='$u' AND password='$p'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['manager_auth'] = true;
        $_SESSION['manager_nama'] = $data['nama_manager'];
        $_SESSION['manager_id']   = $data['id'];
        
        header("Location: manager_dashboard.php");
    } else {
        echo "<script>alert('Login Gagal! Username/Password salah.'); window.location='login_manager.php';</script>";
    }
}
?>