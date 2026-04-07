<?php
include 'koneksi.php';
$q = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY id DESC");
$total_pending = 0;
$html = "";

while ($d = mysqli_fetch_array($q)) {
    if ($d['status_pesanan'] == 'pending') $total_pending++;
    $html .= "<tr>
                <td>{$d['nama_pasien']}</td>
                <td>{$d['tujuan']}</td>
                <td>{$d['status_pesanan']}</td>
                <td>" . ($d['status_pesanan'] == 'pending' ? 
                    "<button class='btn btn-sm btn-success' onclick='prosesPesanan({$d['id']})'>Terima</button>" : "-") . "</td>
              </tr>";
}
echo json_encode(['total_pending' => $total_pending, 'html' => $html]);
?>