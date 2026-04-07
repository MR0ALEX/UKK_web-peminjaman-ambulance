<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_SESSION['username'] ?? 'Guest';
    $unit_id = $_POST['unit_id'] ?? '';
    $lokasi = $_POST['lokasi'] ?? '';
    $tujuan = $_POST['tujuan'] ?? '';

    $q_unit = mysqli_query($conn, "SELECT harga FROM unit_ambulance WHERE id = '$unit_id'");
    $d_unit = mysqli_fetch_assoc($q_unit);
    $harga = $d_unit['harga'] ?? 0;

    if (!empty($unit_id)) {
mysqli_query($conn, "INSERT INTO pesanan (nama_pasien, unit_id, alamat_jemput, tujuan, status_pesanan, harga) 
                     VALUES ('$user', '$unit_id', '$lokasi', '$tujuan', 'waiting', '$harga')");
    }
}
?>