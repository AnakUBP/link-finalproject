<?php
require '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supir = $_POST['id_supir'];
    $id_akun = $_POST['id_akun'];
    $no_sim = $_POST['no_sim'];

    // Proses upload file foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoDir = 'uploads/'; // Direktori tempat menyimpan foto
        if (!is_dir($fotoDir)) {
            mkdir($fotoDir, 0777, true);
        }

        $fotoName = basename($_FILES['foto']['name']);
        $fotoPath = $fotoDir . $fotoName;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath)) {
            $foto = $fotoPath;
        } else {
            echo "Gagal mengunggah foto.";
            exit;
        }
    }

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO supir (id_supir, id_akun, no_sim, foto) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('iiss', $id_supir, $id_akun, $no_sim, $foto);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data supir berhasil ditambahkan!'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>