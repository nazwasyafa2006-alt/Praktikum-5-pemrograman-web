<?php
include 'config.php';

$id = $_GET['id'];
$data = mysqli_query($conn,"SELECT * FROM laporan WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">

<div class="card p-4">
<h4>Edit Laporan</h4>

<form action="update.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $d['id']; ?>">

<input class="form-control mb-2" name="nama" value="<?= $d['nama']; ?>">
<input class="form-control mb-2" name="kategori" value="<?= $d['kategori']; ?>">
<textarea class="form-control mb-2" name="deskripsi"><?= $d['deskripsi']; ?></textarea>

<input type="file" name="foto" class="form-control mb-2">

<button class="btn btn-success">Update</button>
<a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</form>

</div>

</div>
</body>
</html>