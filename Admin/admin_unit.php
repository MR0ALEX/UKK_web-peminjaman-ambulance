<?php
session_start();
include 'koneksi.php';
if($_SESSION['role'] != 'admin') header("location:index.php");

if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    mysqli_query($conn, "INSERT INTO unit_ambulance (nama_unit, harga_dasar) VALUES ('$nama', '$harga')");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Manajemen Unit</title>
</head>
<body class="p-4">
    <div class="container">
        <h3>Kelola Unit Ambulance</h3>
        <form method="POST" class="mb-4">
            <input type="text" name="nama" placeholder="Nama Unit (misal: VIP)" class="form-control mb-2" required>
            <input type="number" name="harga" placeholder="Harga Dasar" class="form-control mb-2" required>
            <button name="tambah" class="btn btn-primary">Tambah Unit</button>
            <a href="admin.php" class="btn btn-secondary">Kembali</a>
        </form>

        <table class="table">
            <tr><th>Unit</th><th>Harga Dasar</th></tr>
            <?php
            $q = mysqli_query($conn, "SELECT * FROM unit_ambulance");
            while($d = mysqli_fetch_array($q)){
                echo "<tr><td>{$d['nama_unit']}</td><td>Rp ".number_format($d['harga'],0,',','.')."</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>