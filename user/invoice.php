<?php
session_start();
include 'koneksi.php';
$id = $_GET['id'];

$q = mysqli_query($conn, "SELECT p.*, u.nama_unit, u.harga 
                          FROM pesanan p 
                          JOIN unit_ambulance u ON p.unit_id = u.id 
                          WHERE p.id='$id'");
$d = mysqli_fetch_array($q);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <title>Detail Transaksi - AmbuCall</title>
    <style>
        body { background-color: #f0f2f5; }
        /* Mengganti warna card dan border atas */
        .card-struk {
            border-top: 6px solid #2c3e50; /* Warna Biru Navy Tua */
            border-radius: 15px;
        }
        /* Warna teks utama */
        .text-primary-custom { color: #2c3e50; }
        /* Gaya tombol kembali */
        .btn-kembali {
            background-color: #2c3e50;
            border: none;
            transition: 0.3s;
        }
        .btn-kembali:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
        }
        .line-dashed {
            border-top: 2px dashed #dee2e6;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5" style="max-width: 450px;">
        <div class="card card-struk shadow-lg p-4 text-center border-0">
            <!-- Icon Berhasil -->
            <div class="mb-3">
                <i class="fas fa-check-circle text-success fa-4x"></i>
            </div>
            
            <h5 class="fw-bold text-secondary">Pembayaran Berhasil</h5>
            <p class="text-muted small">ID Transaksi: #<?php echo $d['id']; ?></p>
            
            <h1 class="fw-bold my-3 text-primary-custom">
                Rp <?php echo number_format($d['harga'], 0, ',', '.'); ?>
            </h1>

            <div class="line-dashed"></div>

            <div class="text-start small px-2">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status</span>
                    <span class="badge bg-success rounded-pill"><?php echo strtoupper($d['status_pesanan']); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Nama Pasien</span>
                    <b class="text-dark"><?php echo $d['nama_pasien']; ?></b>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tujuan</span>
                    <b class="text-dark"><?php echo $d['tujuan']; ?></b>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Unit Ambulance</span>
                    <b class="text-dark"><?php echo $d['nama_unit'] ? $d['nama_unit'] : '-'; ?></b>
                </div>
            </div>

            <div class="line-dashed"></div>

            <div class="text-center mt-2">
                <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    $link_kembali = "admin_dashboard.php";
                } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'manager') {
                    $link_kembali = "manager/manager_dashboard.php";
                } else {
                    $link_kembali = "user_dashboard.php";
                }
                ?>
                <a href="<?php echo $link_kembali; ?>" class="btn btn-kembali text-white w-100 py-2 shadow-sm">
                    <i class="fas fa-house me-2"></i> Kembali ke Dashboard
                </a>
            </div>
            
            <p class="text-muted mt-4 mb-0" style="font-size: 10px;">Terima kasih telah mempercayai layanan AmbuCall</p>
        </div>
    </div>
</body>
</html>