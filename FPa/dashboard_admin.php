<?php
session_start();
require 'fungsi/db.php'; // File konfigurasi koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun']) || !isset($_SESSION['peran'])) {
    header('Location: login.php');
    exit();
}

// Periksa peran pengguna
$peran = $_SESSION['peran'];
if ($peran !== 'admin' && $peran !== 'super admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin dan super admin.'); window.location = 'login.php';</script>";
    exit();
}

// Query untuk mendapatkan data pemesanan
$sql_pemesanan = "
SELECT rp.id_pemesanan, rp.tanggal_pemesanan, rp.tanggal_mulai, rp.tanggal_berakhir,
       m.merek, m.model, m.harga_sewa, m.mobil_foto, lp.status, p.nama_lengkap
FROM rental_pemesanan rp
JOIN list_pemesanan lp ON rp.id_pemesanan = lp.id_pemesanan
JOIN mobil m ON rp.id_mobil = m.id_mobil
JOIN pelanggan p ON rp.id_pelanggan = p.id_pelanggan
WHERE lp.status IN ('belum bayar', 'sudah bayar', 'berlangsung')
";

$result_pemesanan = $conn->query($sql_pemesanan);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background-color:whitesmoke">

    <!-- Include Sidebar -->
    <?php include('include/sidebar.php'); ?>

    <div id="main-content">
        <h1 class="text-center" style="color:black">Dashboard Admin</h1>
        <p class="text-center">Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama_pengguna']); ?></strong>. Anda login sebagai <strong><?= htmlspecialchars($_SESSION['peran']); ?></strong>.</p>
        <div class="container mt-4">
            <div class="card">
                <div class="card-header" style=" background-color:orange">
                    <h2 class="text-center">List Pemesanan</h2>
                </div>
                <?php if ($result_pemesanan->num_rows > 0): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php while ($pemesanan = $result_pemesanan->fetch_assoc()): ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card align-items-center">
                                        <div class="card-body">
                                            <!-- Image of the car -->
                                            <img src="../img/mobil/<?= htmlspecialchars($pemesanan['mobil_foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($pemesanan['merek']); ?>">
                                            <h5 class="card-title"><?php echo htmlspecialchars($pemesanan['merek'] . " " . $pemesanan['model']); ?></h5>
                                            <p class="card-text">
                                                <strong>nama pemesan</strong> <?php echo htmlspecialchars($pemesanan['nama_lengkap']); ?><br>
                                                <strong>Tanggal Pemesanan:</strong> <?php echo htmlspecialchars($pemesanan['tanggal_pemesanan']); ?><br>
                                                <strong>Tanggal Mulai:</strong> <?php echo htmlspecialchars($pemesanan['tanggal_mulai']); ?><br>
                                                <strong>Tanggal Berakhir:</strong> <?php echo htmlspecialchars($pemesanan['tanggal_berakhir']); ?><br>
                                                <strong>Harga Sewa:</strong> Rp<?php echo number_format($pemesanan['harga_sewa'], 0, ',', '.'); ?><br>
                                                <strong>Status:</strong> <?php echo htmlspecialchars($pemesanan['status']); ?>
                                            </p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <a href="edit_pemesanan.php?id_pemesanan=<?php echo $pemesanan['id_pemesanan']; ?>" class="btn btn-warning btn-sm col-12">Edit</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center mt-5 mb-5">Tidak ada riwayat pemesanan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>