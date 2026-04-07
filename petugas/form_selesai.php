<?php
session_start();
include 'koneksi.php';

$id_pesanan = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id='$id_pesanan'");
$d = mysqli_fetch_array($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Laporan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4" style="max-width: 500px;">
    <div class="card shadow-sm p-4">
        <h5 class="fw-bold mb-3 text-danger">LAPORAN AKHIR TUGAS #<?php echo $id_pesanan; ?></h5>
        <form action="proses_simpan_detail.php" method="POST">
            <input type="hidden" name="id_pesanan" value="<?php echo $id_pesanan; ?>">
            
            <div class="mb-3">
                <label class="form-label">Kilometer (KM) Awal</label>
                <input type="number" name="km_awal" class="form-control" placeholder="Contoh: 15000" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kilometer (KM) Akhir</label>
                <input type="number" name="km_akhir" class="form-control" placeholder="Contoh: 15025" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penggunaan Oksigen</label>
                <select name="oksigen" class="form-select">
                    <option value="Tidak Pakai">Tidak Pakai</option>
                    <option value="Sedikit">Sedikit (Masker)</option>
                    <option value="Banyak">Banyak (Tabung Habis)</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Kondisi Pasien</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Pasien stabil selama perjalanan"></textarea>
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-bold">SIMPAN & SELESAIKAN TUGAS</button>
            <a href="petugas_dashboard.php" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
</div>

</body>
</html>