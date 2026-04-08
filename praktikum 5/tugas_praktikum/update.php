<?php
include 'config.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];

if($_FILES['foto']['name'] != ''){
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $folder = "uploads/";
    $nama_file = time().'_'.$foto;

    move_uploaded_file($tmp, $folder.$nama_file);

    mysqli_query($conn,"UPDATE laporan SET 
    nama='$nama',
    kategori='$kategori',
    deskripsi='$deskripsi',
    foto='$nama_file'
    WHERE id='$id'");
}else{
    mysqli_query($conn,"UPDATE laporan SET 
    nama='$nama',
    kategori='$kategori',
    deskripsi='$deskripsi'
    WHERE id='$id'");
}

header("Location: dashboard.php");
exit;
?>