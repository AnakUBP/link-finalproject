<?php
session_start();
include 'fungsi/db.php';

if (!isset($_GET['id_pemesanan'])) {
    header("Location: index.php");
    exit();
}

$id_pemesanan = $_GET['id_pemesanan'];

// Query untuk mendapatkan detail pemesanan
$sql_detail = "
    SELECT rp.tanggal_pemesanan, rp.tanggal_mulai, rp.tanggal_berakhir, 
           m.merek, m.model, m.harga_sewa, m.mobil_foto AS mobil_foto, 
           lp.status AS status_pemesanan, lp.bukti_pembayaran,
           p.nama_pegawai AS nama_supir, p.foto AS foto_supir
    FROM rental_pemesanan rp
    JOIN list_pemesanan lp ON rp.id_pemesanan = lp.id_pemesanan
    JOIN mobil m ON rp.id_mobil = m.id_mobil
    LEFT JOIN pegawai p ON lp.id_supir = p.id_pegawai
    WHERE rp.id_pemesanan = '$id_pemesanan'
";

$result_detail = $conn->query($sql_detail);

if ($result_detail->num_rows === 0) {
    echo "<p class='text-center mt-5'>Pemesanan tidak ditemukan.</p>";
    exit();
}

$detail = $result_detail->fetch_assoc();

// Jika form upload file bukti pembayaran di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti_pembayaran'])) {
    $upload_dir = "../img/buktipembayaran/";
    $file_name = basename($_FILES['bukti_pembayaran']['name']);
    $target_file = $upload_dir . $file_name;
    $upload_ok = true;

    // Validasi file
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "pdf") {
        $upload_ok = false;
        $error_message = "Hanya file JPG, JPEG, PNG, dan PDF yang diizinkan.";
    }

    if ($upload_ok) {
        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file)) {
            // Update bukti pembayaran di database
            $sql_update = "
                UPDATE list_pemesanan 
                SET bukti_pembayaran = '$file_name' 
                WHERE id_pemesanan = '$id_pemesanan'
            ";
            if ($conn->query($sql_update)) {
                $detail['bukti_pembayaran'] = $file_name;
                $success_message = "Bukti pembayaran berhasil diunggah.";
            } else {
                $error_message = "Gagal memperbarui data di database.";
            }
        } else {
            $error_message = "Gagal mengunggah file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Detail Pemesanan</h2>

        <!-- Kartu Detail -->
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="../img/mobil/<?php echo $detail['mobil_foto']; ?>" class="img-fluid rounded-start" alt="Foto Mobil">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $detail['merek'] . " " . $detail['model']; ?></h5>
                        <p class="card-text">
                            <strong>Tanggal Pemesanan:</strong> <?php echo $detail['tanggal_pemesanan']; ?><br>
                            <strong>Tanggal Mulai:</strong> <?php echo $detail['tanggal_mulai']; ?><br>
                            <strong>Tanggal Berakhir:</strong> <?php echo $detail['tanggal_berakhir']; ?><br>
                            <strong>Harga Sewa:</strong> Rp<?php echo number_format($detail['harga_sewa'], 0, ',', '.'); ?><br>
                            <strong>Status Pemesanan:</strong> <?php echo $detail['status_pemesanan']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <?php if (!empty($detail['bukti_pembayaran'])): ?>
                    <p><strong>Bukti Pembayaran:</strong></p>
                    <img src="../img/buktipembayaran/<?= htmlspecialchars($detail['bukti_pembayaran']); ?>" alt="Bukti Pembayaran" class="img-thumbnail mt-2" width="150">
                <?php else: ?>
                    <p><strong>Rekening Pembayaran:</strong></p>
                    <ul class="list-unstyled">
                        <a class="mx-5"><strong>BCA:</strong> 1234567890</a>
                        <a class="mx-5"><strong>Mandiri:</strong> 9876543210</a>
                        <a class="mx-5"><strong>BNI:</strong> 1122334455</a>
                        <a class="mx-5"><strong>BRI:</strong> 5566778899</a>
                    </ul>
                    <form method="POST" enctype="multipart/form-data" class="mt-3">
                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">Unggah Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                        </div>
                        <button type="submit" class="btn btn-success">Unggah</button>
                    </form>
                <?php endif; ?>

                <!-- Informasi Supir -->
                <!-- Informasi Supir -->
                <?php if (!empty($detail['nama_supir'])): ?>
                    <p><strong>Nama Supir:</strong> <?php echo $detail['nama_supir']; ?></p>
                    <img src="../img/pegawai/<?php echo $detail['foto_supir']; ?>" class="img-fluid" alt="Foto Pegawai" style="max-height: 150px;">
                <?php else: ?>
                    <p class="text-danger mt-4">Supir belum ditugaskan.</p>
                <?php endif; ?>

            </div>
        </div>

        <!-- Pesan Error/Sukses -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <!-- Tabel Detail -->
        <h4 class="mb-3">Detail Pemesanan dalam Tabel</h4>
        <div class="row">
            <div class="col-md-4">
                <h5>Tabel Mobil</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Merek</th>
                            <th>Model</th>
                            <th>Harga Sewa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $detail['merek']; ?></td>
                            <td><?php echo $detail['model']; ?></td>
                            <td>Rp<?php echo number_format($detail['harga_sewa'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h5>Tabel Rental Pemesanan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal Pemesanan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $detail['tanggal_pemesanan']; ?></td>
                            <td><?php echo $detail['tanggal_mulai']; ?></td>
                            <td><?php echo $detail['tanggal_berakhir']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h5>Tabel List Pemesanan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Status Pemesanan</th>
                            <th>Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $detail['status_pemesanan']; ?></td>
                            <td>
                                <?php if (!empty($detail['bukti_pembayaran'])): ?>
                                    <a href="../img/buktipembayaran/<?php echo $detail['bukti_pembayaran']; ?>" target="_blank">Lihat Bukti</a>
                                <?php else: ?>
                                    Tidak Ada
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>