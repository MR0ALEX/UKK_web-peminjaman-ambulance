<?php
session_start();
include 'koneksi.php';

$id = $_GET['id']; // ID pesanan
$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id='$id'");
$d = mysqli_fetch_array($q);

if (isset($_POST['upload'])) {
    $nama_file = $_FILES['bukti']['name'];
    $tmp_file = $_FILES['bukti']['tmp_name'];
    $folder = "uploads/"; // Pastikan folder ini ada di direktori Anda!

    if (move_uploaded_file($tmp_file, $folder . $nama_file)) {
        mysqli_query($conn, "UPDATE pesanan SET bukti_transfer='$nama_file', status_pembayaran='menunggu_verifikasi' WHERE id='$id'");
        echo "<script>alert('Bukti berhasil diupload!'); window.location='user_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Upload Pembayaran</title>
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="card p-4 shadow-sm">
        <h4>Upload Bukti Pembayaran</h4>
        <p>Silakan transfer ke: <b>BCA 1234567890 a.n AmbuCall</b></p>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="bukti" class="form-control mb-3" required>
            <button type="submit" name="upload" class="btn btn-success w-100">Kirim Bukti</button>
            <a href="user_dashboard.php" class="btn btn-outline-secondary w-100 mt-2">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>