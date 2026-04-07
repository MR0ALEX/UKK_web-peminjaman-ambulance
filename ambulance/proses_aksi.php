<?php
include 'koneksi.php';

if(isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE pesanan SET status_pesanan='$status' WHERE id='$id'");
    echo "success";
}
?>