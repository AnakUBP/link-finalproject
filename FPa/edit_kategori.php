<?php
// Koneksi database
require_once 'fungsi/db.php';

// Ambil ID kategori dari URL
$id_kategori = $_GET['id_kategori'] ?? null;
if ($id_kategori) {
    // Ambil data kategori berdasarkan ID
    $query = "SELECT * FROM kategori_mobil WHERE id_kategori = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $kategori = $result->fetch_assoc();
    } else {
        // Jika kategori tidak ditemukan
        echo "Kategori tidak ditemukan.";
        exit;
    }
}

// Proses update kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kategori = $_POST['nama_kategori'];
    $jangkauan_kapasitas_penumpang = $_POST['jangkauan_kapasitas_penumpang'];

    $update_query = "UPDATE kategori_mobil SET nama_kategori = ?, jangkauan_kapasitas_penumpang = ? WHERE id_kategori = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $nama_kategori, $jangkauan_kapasitas_penumpang, $id_kategori);

    if ($stmt->execute()) {
        header("Location: rental_cars.php"); // Redirect setelah update
    } else {
        echo "Gagal mengupdate kategori.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Kategori Mobil</h2>
        <div class="card mt-4">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= $kategori['nama_kategori']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jangkauan_kapasitas_penumpang" class="form-label">Jangkauan Kapasitas Penumpang</label>
                        <input type="text" class="form-control" id="jangkauan_kapasitas_penumpang" name="jangkauan_kapasitas_penumpang" value="<?= $kategori['jangkauan_kapasitas_penumpang']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="rental_cars.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>