<?php
require_once 'fungsi/db.php';

// Ambil ID mobil dari query string
$id_mobil = $_GET['id_mobil'] ?? null;

if (!$id_mobil) {
    die("ID mobil tidak ditemukan.");
}

// Ambil data mobil berdasarkan ID
$sql = "SELECT * FROM mobil WHERE id_mobil = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mobil);
$stmt->execute();
$result = $stmt->get_result();
$mobil = $result->fetch_assoc();

if (!$mobil) {
    die("Mobil tidak ditemukan.");
}

// Ambil daftar kategori untuk dropdown
$sql_kategori = "SELECT id_kategori, nama_kategori FROM kategori_mobil";
$result_kategori = $conn->query($sql_kategori);
$kategori_list = $result_kategori->fetch_all(MYSQLI_ASSOC);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kategori = $_POST['id_kategori'];
    $merek = $_POST['merek'];
    $model = $_POST['model'];
    $plat_nomor = $_POST['plat_nomor'];
    $tahun_produksi = $_POST['tahun_produksi'];
    $warna = $_POST['warna'];
    $kapasitas_penumpang = $_POST['kapasitas_penumpang'];
    $harga_sewa = $_POST['harga_sewa'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    $sql_update = "
        UPDATE mobil SET 
            id_kategori = ?, 
            merek = ?, 
            model = ?, 
            plat_nomor = ?, 
            tahun_produksi = ?, 
            warna = ?, 
            kapasitas_penumpang = ?, 
            harga_sewa = ?, 
            deskripsi = ?, 
            status = ? 
        WHERE id_mobil = ?
    ";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param(
        "isssssidsis",
        $id_kategori,
        $merek,
        $model,
        $plat_nomor,
        $tahun_produksi,
        $warna,
        $kapasitas_penumpang,
        $harga_sewa,
        $deskripsi,
        $status,
        $id_mobil
    );

    if ($stmt_update->execute()) {
        header("Location: rental_cars.php");
        exit;
    } else {
        $error = "Gagal memperbarui data mobil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <h3 class="text-center" style="background-color:orange; color:white;">Edit Mobil</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group mb-3">
                    <label>Kategori Mobil</label>
                    <select name="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori_list as $kategori): ?>
                            <option value="<?= $kategori['id_kategori']; ?>"
                                <?= $mobil['id_kategori'] == $kategori['id_kategori'] ? 'selected' : ''; ?>>
                                <?= $kategori['nama_kategori']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Merek</label>
                    <input type="text" name="merek" class="form-control" value="<?= $mobil['merek']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Model</label>
                    <input type="text" name="model" class="form-control" value="<?= $mobil['model']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Plat Nomor</label>
                    <input type="text" name="plat_nomor" class="form-control" value="<?= $mobil['plat_nomor']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Tahun Produksi</label>
                    <input type="number" name="tahun_produksi" class="form-control" value="<?= $mobil['tahun_produksi']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Warna</label>
                    <input type="text" name="warna" class="form-control" value="<?= $mobil['warna']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Kapasitas Penumpang</label>
                    <input type="number" name="kapasitas_penumpang" class="form-control" value="<?= $mobil['kapasitas_penumpang']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Harga Sewa</label>
                    <input type="number" name="harga_sewa" class="form-control" step="0.01" value="<?= $mobil['harga_sewa']; ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="tersedia" <?= $mobil['status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                        <option value="disewa" <?= $mobil['status'] == 'disewa' ? 'selected' : ''; ?>>Disewa</option>
                        <option value="diservis" <?= $mobil['status'] == 'diservis' ? 'selected' : ''; ?>>Diservis</option>
                        <option value="berakhir" <?= $mobil['status'] == 'berakhir' ? 'selected' : ''; ?>>Berakhir</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= $mobil['deskripsi']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="rental_cars.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>