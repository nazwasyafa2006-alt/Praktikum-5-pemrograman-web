<?php
session_start();
include 'config.php';

/* CEK LOGIN */
if(!isset($_SESSION['login'])){
    header("Location: auth.php");
    exit;
}

/* AMBIL DATA */
$data = mysqli_query($conn,"SELECT * FROM laporan");

if(!$data){
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-success">
<div class="container-fluid">
<span class="navbar-brand">GreenDayeuh</span>
<span class="text-white">
    Halo, <?= $_SESSION['name'] ?? 'User'; ?>
</span>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>
</nav>

<div class="container mt-4">

<?php if(isset($_SESSION['success'])){ ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); } ?>

<!-- FORM INPUT -->
<div class="card p-3 mb-4 shadow">
<h5>Input Laporan</h5>

<form action="create.php" method="POST" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-6">
            <input class="form-control" name="nama" placeholder="Nama" required>
        </div>
        <div class="col-md-6">
            <input class="form-control" name="kategori" placeholder="Kategori" required>
        </div>
    </div>

    <textarea class="form-control mt-2" name="deskripsi" placeholder="Deskripsi" required></textarea>

    <!-- UPLOAD FOTO -->
    <div class="mt-2" style="max-width:300px;">
        <label>Upload Foto</label>
        <input type="file" class="form-control" name="foto" accept="image/*" required>
    </div>

    <button class="btn btn-success mt-3">Simpan</button>

</form>
</div>

<!-- DATA -->
<div class="card p-3 shadow">
<h5>Data Laporan</h5>

<table class="table table-bordered table-hover">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Deskripsi</th>
    <th>Foto</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;

if(mysqli_num_rows($data) == 0){
    echo "<tr><td colspan='6' class='text-center'>Data kosong</td></tr>";
}else{
    while($d = mysqli_fetch_array($data)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama']; ?></td>
    <td><?= $d['kategori']; ?></td>
    <td><?= $d['deskripsi']; ?></td>

    <td>
    <?php if(!empty($d['foto'])){ ?>
        <img src="uploads/<?= $d['foto']; ?>" width="80">
    <?php }else{ ?>
        Tidak ada foto
    <?php } ?>
    </td>

    <td>
        <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete.php?id=<?= $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
    </td>
</tr>
<?php } } ?>

</table>

</div>

</div>

</body>
</html>