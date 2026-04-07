<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sewa_ambulance"; // Pastikan ini sama dengan di PHPMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>