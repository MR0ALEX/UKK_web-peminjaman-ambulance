<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$user' AND password = '$pass'");
    $d = mysqli_fetch_assoc($q);

    if ($d) {
       if ($d) {
    $_SESSION['admin'] = true;
    $_SESSION['user'] = false;
    $_SESSION['role'] = 'admin';
    header("Location: admin.php");
}
    } else {
        echo "<script>alert('Login Gagal!');</script>";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 400px;">
        <h3>Login Admin</h3>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>