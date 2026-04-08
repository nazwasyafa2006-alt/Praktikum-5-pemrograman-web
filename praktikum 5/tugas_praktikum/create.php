<?php
include 'config.php';

$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];

$foto = $_FILES['foto']['name'];
$tmp  = $_FILES['foto']['tmp_name'];

/* PAKAI PATH PALING AMAN */
$folder = __DIR__ . "/uploads/";

/* NAMA FILE */
$nama_file = time() . '_' . $foto;

/* PINDAH FILE */
if(move_uploaded_file($tmp, $folder . $nama_file)){

    mysqli_query($conn,"INSERT INTO laporan (nama,kategori,deskripsi,foto)
    VALUES('$nama','$kategori','$deskripsi','$nama_file')");

    header("Location: dashboard.php");
    exit;

}else{
    echo "Upload gagal!";
}
?>