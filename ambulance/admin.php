<?php
session_start();
// Pastikan hanya admin yang bisa masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: proses_login.php");
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - AmbuCall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        #btnAktivasi { position: fixed; bottom: 20px; right: 20px; z-index: 1000; padding: 15px 25px; border-radius: 50px; font-weight: bold; }
        .card { border: none; border-radius: 15px; }
    </style>
</head>
<body>

<button id="btnAktivasi" class="btn btn-danger shadow-lg">
    <i class="fas fa-volume-up me-2"></i>AKTIFKAN SUARA NOTIFIKASI
</button>

<nav class="navbar navbar-dark bg-dark p-3 mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold">AMBUCALL ADMIN</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Keluar</a>
    </div>
</nav>

<div class="container">
    <div id="statusAlert"></div>
    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Daftar Pesanan Ambulans</h4>
            <span id="indikator" class="badge bg-success">Otomatis Aktif</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pasien</th>
                        <th>Tujuan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelData">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<audio id="notifSound" src="alert.mp3" preload="auto"></audio>

<script>
    const audio = document.getElementById("notifSound");
    let audioReady = false;
    let lastOrderCount = null; 

    const btnAktivasi = document.getElementById("btnAktivasi");
    if (btnAktivasi) {
        btnAktivasi.addEventListener("click", function() {
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
                audioReady = true;
                this.style.display = "none"; 
                console.log("Audio Aktif!");
            }).catch(err => console.log("Audio gagal: " + err));
        });
    }

    function fetchUpdates() {
        fetch('get_data_admin.php')
        .then(res => res.json())
        .then(data => {
            // Update isi tabel
            const tabel = document.getElementById('tabelData');
            if (tabel) { tabel.innerHTML = data.html; }

            let currentCount = parseInt(data.jumlah_pending);

            // Jika jumlah pesanan bertambah dari sebelumnya
            if (lastOrderCount !== null && currentCount > lastOrderCount) {
                panggilNotifikasi();
            }
            lastOrderCount = currentCount;
        })
        .catch(err => console.error("Error Fetch:", err));
    }

    function panggilNotifikasi() {
        if (audioReady) {
            audio.currentTime = 0;
            audio.play();
            setTimeout(() => { alert("⚠️ ADA PESANAN BARU!"); }, 500);
        } else {
            alert("⚠️ ADA PESANAN BARU! (Klik tombol aktivasi suara agar bunyi)");
        }
    }

    function updateStatus(id, status) {
        if(!confirm('Yakin ingin mengubah status ke ' + status + '?')) return;

        let params = new URLSearchParams();
        params.append('id', id);
        params.append('status', status);

        fetch('update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params
        })
        .then(res => res.text())
        .then(data => {
            if(data.trim() === "success") {
                // Refresh data tabel setelah update berhasil
                fetchUpdates(); 
            } else {
                alert("Gagal update: " + data);
            }
        })
        .catch(err => alert("Error koneksi: " + err));
    }

    setInterval(fetchUpdates, 3000);
    fetchUpdates(); // Panggil sekali saat start
</script>
</body>
</html>