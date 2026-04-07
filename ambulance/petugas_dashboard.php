<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user_pet']);
    $password = mysqli_real_escape_string($conn, $_POST['pass_pet']);
    
    $query = "SELECT * FROM petugas_akun WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $petugas = mysqli_fetch_assoc($result);
        $_SESSION['petugas_auth'] = true;
        $_SESSION['petugas_id'] = $petugas['id'];
        $_SESSION['petugas_nama'] = $petugas['nama_petugas'];
        $_SESSION['petugas_unit'] = $petugas['id_unit'];
        $_SESSION['petugas_status'] = $petugas['status_tugas'];
        header("Location: petugas_dashboard.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: petugas_dashboard.php");
    exit();
}

if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    
    if ($_GET['ajax'] == 'get_tugas') {
        $filter = $_GET['filter'] ?? 'all';
        
        $sql = "SELECT p.*, u.nama_unit 
                FROM pesanan p 
                LEFT JOIN unit_ambulance u ON p.unit_id = u.id";
        
        if ($filter !== 'all') {
            $sql .= " WHERE p.status_pesanan = '$filter'";
        }
        
        $sql .= " ORDER BY FIELD(p.status_pesanan, 'proses', 'waiting', 'selesai'), p.id DESC";
        
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit();
        }
        
        $html = '';
        $total_tugas = 0;
        $total_proses = 0;
        $total_selesai = 0;
        $total_waiting = 0;
        
        while ($row = mysqli_fetch_assoc($result)) {
            $total_tugas++;
            if ($row['status_pesanan'] == 'proses') $total_proses++;
            if ($row['status_pesanan'] == 'selesai') $total_selesai++;
            if ($row['status_pesanan'] == 'waiting') $total_waiting++;
            
            $statusClass = '';
            $statusText = '';
            switch($row['status_pesanan']) {
                case 'waiting':
                    $statusClass = 'status-waiting';
                    $statusText = 'Menunggu';
                    break;
                case 'proses':
                    $statusClass = 'status-proses';
                    $statusText = 'Diproses';
                    break;
                case 'selesai':
                    $statusClass = 'status-selesai';
                    $statusText = 'Selesai';
                    break;
            }
            
            $harga = $row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-';
            $unit = $row['nama_unit'] ? $row['nama_unit'] : 'Unit ' . $row['unit_id'];
            
            $html .= '<tr>';
            $html .= '<td>' . $row['id'] . '</td>';
            $html .= '<td><strong>' . htmlspecialchars($row['nama_pasien']) . '</strong><br><small class="text-muted">' . htmlspecialchars($unit) . '</small></td>';
            $html .= '<td>' . htmlspecialchars(substr($row['alamat_jemput'], 0, 40)) . '</td>';
            $html .= '<td>' . htmlspecialchars(substr($row['tujuan'], 0, 40)) . '</td>';
            $html .= '<td>' . $harga . '</td>';
            $html .= '<td><span class="status-badge ' . $statusClass . '">' . $statusText . '</span></td>';
            $html .= '<td>';
            
            if ($row['status_pesanan'] == 'waiting') {
                $html .= '<button class="btn btn-sm btn-primary" onclick="ambilTugas(' . $row['id'] . ')">
                            <i class="fas fa-play"></i> Ambil
                          </button>';
            } elseif ($row['status_pesanan'] == 'proses') {
                $html .= '<button class="btn btn-sm btn-success" onclick="selesaikanTugas(' . $row['id'] . ')">
                            <i class="fas fa-check"></i> Selesai
                          </button>';
            } else {
                $html .= '<span class="text-muted"><i class="fas fa-check-circle"></i> Selesai</span>';
            }
            
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        if (empty($html)) {
            $html = '<tr><td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-2 d-block"></i>
                        Tidak ada tugas
                      </td>' . '</tr>';
        }
        
        echo json_encode([
            'html' => $html,
            'total_tugas' => $total_tugas,
            'total_proses' => $total_proses,
            'total_selesai' => $total_selesai,
            'total_waiting' => $total_waiting
        ]);
        exit();
    }
    
    if ($_GET['ajax'] == 'ambil_tugas') {
        $id = $_POST['id'];
        $petugas_id = $_SESSION['petugas_id'];
        $unit_id = $_SESSION['petugas_unit'];
        
        $query = "UPDATE pesanan SET status_pesanan = 'proses' WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) {
            mysqli_query($conn, "UPDATE petugas_akun SET status_tugas = 'on-duty' WHERE id = '$petugas_id'");
            
            if ($unit_id) {
                mysqli_query($conn, "UPDATE unit_ambulance SET status = 'dipakai' WHERE id = '$unit_id'");
            }
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        }
        exit();
    }
    
    if ($_GET['ajax'] == 'selesai_tugas') {
        $id = $_POST['id'];
        $petugas_id = $_SESSION['petugas_id'];
        $unit_id = $_SESSION['petugas_unit'];
        
        $query = "UPDATE pesanan SET status_pesanan = 'selesai' WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) {
            mysqli_query($conn, "UPDATE petugas_akun SET status_tugas = 'standby' WHERE id = '$petugas_id'");
            
            if ($unit_id) {
                mysqli_query($conn, "UPDATE unit_ambulance SET status = 'tersedia' WHERE id = '$unit_id'");
            }
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        }
        exit();
    }
}

if (!isset($_SESSION['petugas_auth']) || $_SESSION['petugas_auth'] !== true) {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Petugas | AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #2c3e50; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 350px; border-radius: 15px; border-top: 5px solid #e74c3c; background: white; }
    </style>
</head>
<body>
<div class="card login-card shadow p-4">
    <h4 class="text-center fw-bold mb-4">PETUGAS LOGIN</h4>
    <?php if (isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="small fw-bold">USERNAME</label>
            <input type="text" name="user_pet" class="form-control" required>
        </div>
        <div class="mb-4">
            <label class="small fw-bold">PASSWORD</label>
            <input type="password" name="pass_pet" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-danger w-100 fw-bold">MASUK TUGAS</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    exit();
}

$petugas_nama = $_SESSION['petugas_nama'];
$petugas_unit = $_SESSION['petugas_unit'];

$namaUnit = 'Belum ditentukan';
if ($petugas_unit) {
    $queryUnit = "SELECT nama_unit FROM unit_ambulance WHERE id = '$petugas_unit'";
    $resultUnit = mysqli_query($conn, $queryUnit);
    $rowUnit = mysqli_fetch_assoc($resultUnit);
    $namaUnit = $rowUnit ? $rowUnit['nama_unit'] : 'Unit ' . $petugas_unit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petugas Dashboard | AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; }
        .sidebar { 
            height: 100vh; 
            width: 260px; 
            position: fixed; 
            background: linear-gradient(180deg, #c0392b 0%, #96281b 100%);
            color: white; 
            padding: 20px; 
        }
        .main-content { margin-left: 260px; padding: 30px; }
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-waiting { background: #f39c12; color: white; }
        .status-proses { background: #3498db; color: white; }
        .status-selesai { background: #27ae60; color: white; }
        .info-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .nav-link { color: white; padding: 12px 15px; border-radius: 10px; transition: 0.3s; margin-bottom: 5px; }
        .nav-link:hover { background: rgba(255,255,255,0.15); color: white; }
        .nav-link.active { background: rgba(255,255,255,0.25); }
        .btn-sm { padding: 5px 12px; margin: 2px; border-radius: 8px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center fw-bold mb-4">
        <i class="fas fa-ambulance me-2"></i>AmbuCall
    </h4>
    <hr class="bg-light opacity-25">
    <nav class="nav flex-column">
        <a href="#" class="nav-link active" onclick="filterTugas('all')">
            <i class="fas fa-tasks me-2"></i> Semua Tugas
        </a>
        <a href="#" class="nav-link" onclick="filterTugas('waiting')">
            <i class="fas fa-clock me-2"></i> Menunggu
        </a>
        <a href="#" class="nav-link" onclick="filterTugas('proses')">
            <i class="fas fa-play-circle me-2"></i> Diproses
        </a>
        <a href="#" class="nav-link" onclick="filterTugas('selesai')">
            <i class="fas fa-check-circle me-2"></i> Selesai
        </a>
        <hr class="bg-light opacity-25 mt-4">
        <a href="?logout=1" class="nav-link">
            <i class="fas fa-sign-out-alt me-2"></i> Keluar
        </a>
    </nav>
</div>

<div class="main-content">
    <div class="info-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4><i class="fas fa-user-circle me-2 text-danger"></i> <?php echo htmlspecialchars($petugas_nama); ?></h4>
                <p class="mb-0 text-muted">
                    <i class="fas fa-truck me-1"></i> Unit: <?php echo htmlspecialchars($namaUnit); ?>
                </p>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-<?php echo $_SESSION['petugas_status'] == 'on-duty' ? 'success' : 'secondary'; ?> p-3 px-4 fs-6">
                    <i class="fas fa-<?php echo $_SESSION['petugas_status'] == 'on-duty' ? 'ambulance' : 'bed'; ?> me-2"></i>
                    <?php echo $_SESSION['petugas_status'] == 'on-duty' ? 'ON DUTY' : 'STANDBY'; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="info-card text-center">
                <i class="fas fa-clipboard-list fa-2x text-danger mb-2"></i>
                <h2 class="fw-bold mb-0" id="totalTugas">0</h2>
                <p class="text-muted mb-0">Total Tugas</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card text-center">
                <i class="fas fa-spinner fa-2x text-primary mb-2"></i>
                <h2 class="fw-bold mb-0 text-primary" id="totalProses">0</h2>
                <p class="text-muted mb-0">Sedang Diproses</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h2 class="fw-bold mb-0 text-success" id="totalSelesai">0</h2>
                <p class="text-muted mb-0">Selesai</p>
            </div>
        </div>
    </div>

    <!-- Tabel Tugas -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-danger"></i>Daftar Tugas Lapangan
                </h5>
                <small class="text-muted" id="lastUpdate">
                    <i class="fas fa-clock me-1"></i> Loading...
                </small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Pasien / Unit</th>
                            <th>Alamat Jemput</th>
                            <th>Tujuan</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelData">
                        <tr><td colspan="7" class="text-center py-5"><div class="spinner-border text-danger"></div><p class="mt-2">Memuat data...</p></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let currentFilter = 'all';

function filterTugas(status) {
    currentFilter = status;
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    if(event && event.target) event.target.classList.add('active');
    loadTugas();
}

function loadTugas() {
    fetch(`?ajax=get_tugas&filter=${currentFilter}`)
        .then(res => res.json())
        .then(data => {
            if(data.error) {
                console.error(data.error);
                document.getElementById('tabelData').innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error: ' + data.error + '</td></tr>';
                return;
            }
            document.getElementById('tabelData').innerHTML = data.html;
            document.getElementById('totalTugas').innerText = data.total_tugas;
            document.getElementById('totalProses').innerText = data.total_proses;
            document.getElementById('totalSelesai').innerText = data.total_selesai;
            document.getElementById('lastUpdate').innerHTML = '<i class="fas fa-clock me-1"></i> Update: ' + new Date().toLocaleTimeString();
        })
        .catch(err => {
            console.error(err);
            document.getElementById('tabelData').innerHTML = '<tr><td colspan="7" class="text-center text-danger py-4">Gagal memuat data</td></tr>';
        });
}

function ambilTugas(id) {
    if(!confirm('Ambil tugas ini?')) return;
    
    fetch(`?ajax=ambil_tugas`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Tugas berhasil diambil!');
            loadTugas();
            setTimeout(() => location.reload(), 500);
        } else {
            alert('Gagal: ' + data.message);
        }
    });
}

function selesaikanTugas(id) {
    if(!confirm('Selesaikan tugas ini?')) return;
    
    fetch(`?ajax=selesai_tugas`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Tugas selesai!');
            loadTugas();
            setTimeout(() => location.reload(), 500);
        } else {
            alert('Gagal: ' + data.message);
        }
    });
}

setInterval(loadTugas, 5000);
loadTugas();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>