<?php
session_start();
include 'koneksi.php';

$user = isset($_SESSION['username']) ? $_SESSION['username'] : ''; 

$q = mysqli_query($conn, "SELECT p.*, u.nama_unit, u.harga 
                          FROM pesanan p 
                          LEFT JOIN unit_ambulance u ON p.unit_id = u.id 
                          WHERE p.nama_pasien = '$user' 
                          ORDER BY p.id DESC");

if (!$q) {
    die("Query Error: " . mysqli_error($conn));
}

while($d = mysqli_fetch_array($q)){
    $unit = $d['nama_unit'] ? $d['nama_unit'] : "-";
    $harga = isset($d['harga']) ? number_format($d['harga'], 0, ',', '.') : "0";
    $status = strtolower($d['status_pesanan']);
 
    $warna = 'bg-secondary';
    if ($status == 'proses') $warna = 'bg-warning text-dark';
    elseif ($status == 'proses') $warna = 'bg-primary';
    elseif ($status == 'selesai') $warna = 'bg-success';

    echo "<tr>
        <td>{$d['tujuan']}</td>
        <td>{$unit} <br> <small class='text-muted'>Rp {$harga}</small></td>
        <td><span class='badge {$warna}'>" . strtoupper($status) . "</span></td>
        <td>
            <a href='invoice.php?id={$d['id']}' class='btn btn-sm btn-info' target='_blank'>Struk</a>";
            
            if ($status == 'proses') {
                echo " <a href='pembayaran.php?id={$d['id']}' class='btn btn-sm btn-primary'>Bayar</a>";
            }
            
echo "  </td>
      </tr>";
}
?>