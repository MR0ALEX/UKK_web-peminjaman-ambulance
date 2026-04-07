<?php
include 'koneksi.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $q = mysqli_query($conn, "UPDATE pesanan SET status_pesanan='$status' WHERE id='$id'");
    
    if ($q) {
        echo "success";
    } else {
        echo "Error SQL: " . mysqli_error($conn);
    }
} else {
    echo "Error: Data tidak diterima oleh PHP. ID: " . (isset($_POST['id']) ? $_POST['id'] : 'kosong') . 
         ", Status: " . (isset($_POST['status']) ? $_POST['status'] : 'kosong');
}
?>