<?php
require_once 'start.php';

// Cek login sederhana
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    die("Harap login terlebih dahulu.");
}

// Koneksi database (sesuaikan)
$koneksi = new mysqli("localhost", "root", "", "tugas_crud");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    // Upload file
    $uploadDir = 'uploads/';
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    $filePath = "";
    if (isset($_FILES['berkas']) && $_FILES['berkas']['error'] === 0) {
        $fileName = basename($_FILES['berkas']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExt, $allowedTypes)) {
            $newFileName = time() . "_" . $fileName;
            $targetFile = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['berkas']['tmp_name'], $targetFile)) {
                $filePath = $targetFile;
            } else {
                $message = "Gagal mengunggah file.";
            }
        } else {
            $message = "Tipe file tidak diizinkan.";
        }
    }

    // Simpan ke database
    if (empty($message)) {
        $stmt = $koneksi->prepare("INSERT INTO items (nama, deskripsi, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $deskripsi, $filePath);
        if ($stmt->execute()) {
            $message = "Data berhasil disimpan dengan upload file.";
        } else {
            $message = "Gagal menyimpan data: " . $koneksi->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD + Upload File</title>
</head>
<body>
    <h2>Form Tambah Data</h2>
    <p><?php echo $message; ?></p>
    <form method="post" enctype="multipart/form-data">
        Nama: <input type="text" name="nama" required><br>
        Deskripsi: <textarea name="deskripsi" required></textarea><br>
        Upload Berkas (jpg, jpeg, png, pdf): <input type="file" name="berkas"><br>
        <input type="submit" name="simpan" value="Simpan">
    </form>

    <hr>
    <h3>Daftar Data</h3>
    <table border="1">
        <tr><th>ID</th><th>Nama</th><th>Deskripsi</th><th>File</th><th>Aksi</th></tr>
        <?php
        $result = $koneksi->query("SELECT * FROM items");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['deskripsi']}</td>";
            echo "<td><a href='{$row['file_path']}' target='_blank'>Lihat File</a></td>";
            echo "<td>
                    <a href='edit.php?id={$row['id']}'>Edit</a> |
                    <a href='delete.php?id={$row['id']}'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>