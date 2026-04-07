<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = $_POST['id_pesanan'];
    $km_awal = $_POST['km_awal'];
    $km_akhir = $_POST['km_akhir'];
    $oksigen = $_POST['oksigen'];
    $catatan = $_POST['catatan'];

    $query_detail = "INSERT INTO detail_tugas (id_pesanan, km_awal, km_akhir, penggunaan_oksigen, catatan_petugas) 
                     VALUES ('$id_pesanan', '$km_awal', '$km_akhir', '$oksigen', '$catatan')";
    
    if (mysqli_query($conn, $query_detail)) {
        mysqli_query($conn, "UPDATE pesanan SET status_pesanan='selesai' WHERE id='$id_pesanan'");
        
        echo "<script>alert('Laporan tersimpan, tugas selesai!'); window.location='petugas_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>