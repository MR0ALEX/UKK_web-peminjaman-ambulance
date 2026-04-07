<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['manager_auth'])) { header("Location: login_manager.php"); exit(); }

$q_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan");
$total_order = mysqli_fetch_assoc($q_total)['total'] ?? 0;

$q_duit = mysqli_query($conn, "SELECT SUM(harga) as total FROM pesanan WHERE status_pesanan='selesai'");
$duit = mysqli_fetch_assoc($q_duit)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manager | AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #343a40; color: white; padding: 20px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-box { border: none; border-radius: 10px; transition: 0.3s; }
        .card-box:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h4 class="text-center fw-bold mb-5 text-primary">AMBU<span class="text-white">CALL</span></h4>
    <hr>
    <p class="small text-muted">MENU UTAMA</p>
    <a href="#" class="nav-link text-white mb-3 active"><i class="fas fa-home me-2"></i> Dashboard</a>
    <a href="generate_laporan.php" class="nav-link text-white mb-3"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="#" class="nav-link text-white mb-3"><i class="fas fa-ambulance me-2"></i> Armada</a>
    <hr>
    <a href="logout_manager.php" class="btn btn-danger btn-sm w-100"><i class="fas fa-sign-out-alt"></i> Keluar</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ringkasan Operasional</h2>
        <span class="badge bg-primary p-2 px-3">Manager: <?php echo $_SESSION['manager_nama']; ?></span>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-box bg-white shadow-sm p-4 border-start border-success border-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">TOTAL PENDAPATAN</p>
                        <h3 class="fw-bold">Rp <?php echo number_format($duit, 0, ',', '.'); ?></h3>
                    </div>
                    <i class="fas fa-wallet fa-2x text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box bg-white shadow-sm p-4 border-start border-primary border-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">TOTAL PESANAN</p>
                        <h3 class="fw-bold"><?php echo $total_order; ?> Order</h3>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box bg-white shadow-sm p-4 border-start border-warning border-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">ARMADA AKTIF</p>
                        <h3 class="fw-bold">4 Unit</h3>
                    </div>
                    <i class="fas fa-ambulance fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-5">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">5 Pesanan Terakhir</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pasien</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY id DESC LIMIT 5");
                    while($row = mysqli_fetch_assoc($res)){
                        $badge = ($row['status_pesanan'] == 'selesai') ? 'success' : 'warning';
                        echo "<tr>
                                <td>#{$row['id']}</td>
                                <td>{$row['nama_pasien']}</td>
                                <td>{$row['tujuan']}</td>
                                <td><span class='badge bg-$badge'>{$row['status_pesanan']}</span></td>
                                <td>Rp ".number_format($row['harga'],0,',','.')."</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>