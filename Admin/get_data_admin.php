<?php
include 'koneksi.php';
header('Content-Type: application/json');

$q_waiting = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM pesanan WHERE status_pesanan='waiting'");
$d_waiting = mysqli_fetch_assoc($q_waiting);
$jumlah_waiting = (int)$d_waiting['jumlah'];

$q_tabel = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY id DESC");
$html = "";

while($r = mysqli_fetch_array($q_tabel)){
    $status_label = ($r['status_pesanan'] == 'waiting') 
        ? "<span class='badge bg-danger'>Waiting</span>" 
        : "<span class='badge bg-success'>{$r['status_pesanan']}</span>";

    $html .= "<tr>
        <td>{$r['nama_pasien']}</td>
        <td>{$r['tujuan']}</td>
        <td>Rp " . number_format($r['harga'], 0, ',', '.') . "</td>
        <td>{$status_label}</td>
        <td>
            <button class='btn btn-sm btn-primary' onclick='updateStatus({$r['id']}, \"proses\")'>Proses</button>
            <button class='btn btn-sm btn-success' onclick='updateStatus({$r['id']}, \"selesai\")'>Selesai</button>
        </td>
    </tr>";
}

echo json_encode([
    'jumlah_pending' => $jumlah_waiting, // Kita tetap pakai nama key 'jumlah_pending' agar JS tidak perlu diubah banyak
    'html' => $html
]);
exit();
?>