<?php
session_start();
require 'fungsi/db.php'; // File konfigurasi koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun']) || !isset($_SESSION['peran'])) {
    header('Location: login.php');
    exit();
}

// Periksa apakah pengguna memiliki hak akses
$peran = $_SESSION['peran'];
if ($peran !== 'admin' && $peran !== 'super admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin dan super admin.'); window.location = 'login.php';</script>";
    exit();
}

// Ambil data dari tabel mobil, pelanggan, dan pegawai (supir)
$sql_mobil = "SELECT * FROM mobil";
$result_mobil = $conn->query($sql_mobil);

$sql_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = $conn->query($sql_pelanggan);

$sql_supir = "SELECT id_pegawai, nama_pegawai, foto FROM pegawai WHERE jabatan = 'supir'";
$result_supir = $conn->query($sql_supir);

// Ambil detail pemesanan berdasarkan ID pemesanan
$id_pemesanan = $_GET['id_pemesanan'] ?? null;
if (!$id_pemesanan) {
    echo "<script>alert('ID pemesanan tidak ditemukan!'); window.location = 'dashboard_admin.php';</script>";
    exit();
}

$sql_pemesanan = "
SELECT rp.*, lp.id_supir, lp.bukti_pembayaran, lp.status, p.nama_lengkap AS nama_pelanggan, m.merek, m.model 
FROM rental_pemesanan rp
JOIN list_pemesanan lp ON rp.id_pemesanan = lp.id_pemesanan
JOIN pelanggan p ON rp.id_pelanggan = p.id_pelanggan
JOIN mobil m ON rp.id_mobil = m.id_mobil
WHERE rp.id_pemesanan = $id_pemesanan
";
$result_pemesanan = $conn->query($sql_pemesanan);
$pemesanan = $result_pemesanan->fetch_assoc();

// Proses update pemesanan
// Proses update pemesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supir = $_POST['id_supir'] ?? null;
    $status = $_POST['status'] ?? null;

    // Proses upload bukti pembayaran
    if (!empty($_FILES['bukti_pembayaran']['name'])) {
        $bukti_pembayaran = "uploads/" . basename($_FILES['bukti_pembayaran']['name']);
        move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $bukti_pembayaran);
    } else {
        $bukti_pembayaran = $pemesanan['bukti_pembayaran']; // Menggunakan nilai yang sudah ada sebelumnya
    }

    // Jika tidak ada perubahan pada supir, maka simpan id_supir yang sebelumnya
    if (!$id_supir) {
        $id_supir = $pemesanan['id_supir'];
    }

    // Update data ke database
    $sql_update = "
    UPDATE list_pemesanan
    SET id_supir = ?, bukti_pembayaran = ?, status = ?
    WHERE id_pemesanan = ?
    ";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("issi", $id_supir, $bukti_pembayaran, $status, $id_pemesanan);
    if ($stmt->execute()) {
        echo "<script>alert('Data pemesanan berhasil diperbarui!'); window.location = 'dashboard_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data pemesanan!');</script>";
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
        <h2 class="text-center" style="background-color:orange">Edit Pemesanan</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="mobil" class="form-label">Mobil</label>
                <input type="text" class="form-control" id="mobil" value="<?= htmlspecialchars($pemesanan['merek'] . ' ' . $pemesanan['model']); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="pelanggan" class="form-label">Pelanggan</label>
                <input type="text" class="form-control" id="pelanggan" value="<?= htmlspecialchars($pemesanan['nama_pelanggan']); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="supir" class="form-label">Supir</label>
                <select class="form-select" id="supir" name="id_supir">
                    <option value="">Pilih Supir</option>
                    <?php while ($supir = $result_supir->fetch_assoc()): ?>
                        <option value="<?= $supir['id_pegawai']; ?>" <?= ($pemesanan['id_supir'] == $supir['id_pegawai']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($supir['nama_pegawai']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <?php if ($pemesanan['id_supir']): ?>
                    <img src="../img/pegawai/<?= htmlspecialchars($pemesanan['foto']); ?>" alt="Foto Supir" class="img-thumbnail mt-2" width="100">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="belum bayar" <?= ($pemesanan['status'] == 'belum bayar') ? 'selected' : ''; ?>>Belum Bayar</option>
                    <option value="sudah bayar" <?= ($pemesanan['status'] == 'sudah bayar') ? 'selected' : ''; ?>>Sudah Bayar</option>
                    <option value="berlangsung" <?= ($pemesanan['status'] == 'berlangsung') ? 'selected' : ''; ?>>Berlangsung</option>
                    <option value="selesai" <?= ($pemesanan['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="batal" <?= ($pemesanan['status'] == 'batal') ? 'selected' : ''; ?>>Batal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                <?php if (!empty($pemesanan['bukti_pembayaran'])): ?>
                    <div class="mt-2">
                        <!-- Menampilkan link untuk bukti pembayaran -->
                        <a href="../img/buktipembayaran/<?= htmlspecialchars($pemesanan['bukti_pembayaran']); ?>" target="_blank"><?= htmlspecialchars($pemesanan['bukti_pembayaran']); ?></a>
                    </div>
                <?php else: ?>
                    <p>Tidak ada bukti pembayaran.</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="dashboard_admin.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>