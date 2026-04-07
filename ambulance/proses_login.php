<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$q_check_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
if (mysqli_num_rows($q_check_admin) > 0) {
    echo "<script>
            alert('Akun Admin terdeteksi! Silakan login melalui halaman khusus Admin.');
            window.location='login_admin.php';
          </script>";
    exit;
}

$q_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$d_user = mysqli_fetch_array($q_user);

if ($d_user) {
    $_SESSION['role'] = 'user';
    $_SESSION['username'] = $d_user['username']; 
    $_SESSION['user_id'] = $d_user['id'];
    header("Location: user_dashboard.php");
    exit;
} else {
    echo "<script>alert('Login Gagal! Username atau Password salah.'); window.location='login_admin.php';</script>";
}
?>