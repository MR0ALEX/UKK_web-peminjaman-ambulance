<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    die("Akses Ditolak.");
}

$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE status_pesanan='selesai' ORDER BY id DESC");

$q_total = mysqli_query($conn, "SELECT SUM(harga) as grand_total FROM pesanan WHERE status_pesanan='selesai'");
$r_total = mysqli_fetch_assoc($q_total);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: white; font-family: 'Arial', sans-serif; }
        .header-laporan { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()"> <div class="container mt-5">
    <div class="no-print mb-4">
        <a href="manager_dashboard.php" class="btn btn-secondary"> Kembali ke Dashboard</a>
        <button onclick="window.print()" class="btn btn-primary">Cetak / Simpan PDF</button>
    </div>

    <div class="header-laporan text-center">
        <h2 class="fw-bold">AMBUCALL - SISTEM SEWA AMBULANS</h2>
        <p class="mb-0">Yogyakarta, Indonesia | Telp: 0812-xxxx-xxxx</p>
        <h4 class="mt-3 text-uppercase">Laporan Pendapatan Selesai</h4>
    </div>

    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr class="text-center">
                <th>No. Pesanan</th>
                <th>Nama Pasien</th>
                <th>Tujuan</th>
                <th>Status</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td class="text-center">#<?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama_pasien']; ?></td>
                    <td><?php echo $row['tujuan']; ?></td>
                    <td class="text-center text-success fw-bold">SELESAI</td>
                    <td class="text-end">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                </tr>
            <?php } 
            } else {
                echo "<tr><td colspan='5' class='text-center'>Belum ada data pesanan selesai.</td></tr>";
            } ?>
        </tbody>
        <tfoot>
            <tr class="table-secondary fw-bold">
                <td colspan="4" class="text-center">TOTAL PENDAPATAN</td>
                <td class="text-end text-primary">Rp <?php echo number_format($r_total['grand_total'], 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p>Yogyakarta, <?php echo date('d F Y'); ?></p>
            <p class="mb-5">Mengetahui,</p>
            <br><br>
            <p class="fw-bold"><u>( Nama Manajer )</u><br>Manajer Operasional</p>
        </div>
    </div>
</div>

</body>
</html>