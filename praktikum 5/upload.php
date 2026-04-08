<?php
$uploadDir = 'uploads/';

// CEK APAKAH FOLDER UPLOADS ADA, JIKA TIDAK BUAT FOLDER
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
    echo "Folder uploads berhasil dibuat.<br>";
}

$allowedTypes = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $fileName = basename($_FILES['fileToUpload']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $targetFile = $uploadDir . $fileName;

    // Cek apakah file benar-benar gambar
    $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
    if ($check !== false && in_array($fileExt, $allowedTypes)) {
        
        // Hindari duplikasi nama file
        $counter = 1;
        $newFileName = $fileName;
        while (file_exists($uploadDir . $newFileName)) {
            $pathInfo = pathinfo($fileName);
            $newFileName = $pathInfo['filename'] . "_$counter." . $fileExt;
            $counter++;
        }
        $targetFile = $uploadDir . $newFileName;

        // PASTIKAN FOLDER UPLOADS ADA SEBELUM MOVE FILE
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // COBA UPLOAD FILE
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
            echo "File berhasil diunggah ke: " . $targetFile . "<br>";
            echo "<img src='$targetFile' width='300' alt='Gambar'>";
        } else {
            echo "Gagal mengunggah file.<br>";
            echo "Error detail: <br>";
            echo "- Temporary file: " . $_FILES['fileToUpload']['tmp_name'] . "<br>";
            echo "- Target file: " . $targetFile . "<br>";
            echo "- Upload error code: " . $_FILES['fileToUpload']['error'] . "<br>";
        }
    } else {
        echo "File tidak valid atau format tidak didukung (hanya JPG, JPEG, PNG).";
    }
} else {
    echo "Tidak ada file yang diunggah.";
}
?>