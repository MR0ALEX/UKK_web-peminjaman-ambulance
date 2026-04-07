<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("location:index.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard Penyewa</title>
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card p-4">
                <h5>Pesan Darurat</h5>
                <form id="formPesan">
                    <select name="unit_id" id="unitSelect" class="form-select mb-3" onchange="tampilkanHarga()" required>
                        <option value="">Pilih Jenis Unit</option>
                        <?php
                        $q_unit = mysqli_query($conn, "SELECT * FROM unit_ambulance");
                        while($u = mysqli_fetch_array($q_unit)){
                            echo "<option value='{$u['id']}' data-harga='{$u['harga']}'>{$u['nama_unit']}</option>";
                        }
                        ?>
                    </select>
                    <p id="infoHarga" class="fw-bold text-danger"></p>
                    <input type="text" name="lokasi" class="form-control mb-3" placeholder="Lokasi Jemput" required>
                    <input type="text" name="tujuan" class="form-control mb-3" placeholder="RS Tujuan" required>
                    <button type="button" onclick="kirimPesanan()" class="btn btn-danger w-100">PANGGIL SEKARANG</button>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card p-3">
                <h5>Riwayat Panggilan Anda</h5>
                <table class="table mt-3">
                    <thead><tr><th>Tujuan</th><th>Unit</th><th>Status</th></tr></thead>
                    <tbody id="isi-riwayat"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    window.tampilkanHarga = function() {
        var select = document.getElementById("unitSelect");
        var harga = select.options[select.selectedIndex].getAttribute("data-harga");
        var info = document.getElementById("infoHarga");
        if(harga) {
            var formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
            info.innerText = "Estimasi Biaya: " + formatter.format(harga);
        } else { info.innerText = ""; }
    };

    window.kirimPesanan = function() {
        var form = document.getElementById('formPesan');
        var formData = new FormData(form);

        fetch('proses_pesan.php', {
            method: 'POST',
            body: formData
        })
        .then(() => {
            form.reset();
            document.getElementById('infoHarga').innerText = "";
            if(typeof updateRiwayat === 'function') {
                updateRiwayat();
            }
        })
        .catch(error => console.error('Error:', error));
    };

    window.updateRiwayat = function() {
        fetch('get_riwayat.php')
            .then(res => res.text())
            .then(data => { document.getElementById('isi-riwayat').innerHTML = data; });
    };

    updateRiwayat();
    setInterval(updateRiwayat, 3000);
});
</script>
</body>
</html>