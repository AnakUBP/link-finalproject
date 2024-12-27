<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki peran 'pelanggan'
if (!isset($_SESSION['id_akun']) || $_SESSION['peran'] !== 'pelanggan') {
    header('Location: login.php'); // Arahkan ke login jika bukan pelanggan
    exit;
}

include('fungsi/db.php');

// Ambil data pelanggan berdasarkan id_akun dari sesi
$id_akun = $_SESSION['id_akun'];
$query_pelanggan = "SELECT id_pelanggan, alamat, no_telepon FROM pelanggan WHERE id_akun = $id_akun";
$result_pelanggan = $conn->query($query_pelanggan);

if ($result_pelanggan && $result_pelanggan->num_rows > 0) {
    $data_pelanggan = $result_pelanggan->fetch_assoc();
    $id_pelanggan = $data_pelanggan['id_pelanggan'];
} else {
    echo "<script>alert('Data pelanggan tidak ditemukan. Silakan lengkapi profil Anda.');</script>";
    exit;
}

// Jika mobil dipilih
if (isset($_GET['id_mobil'])) {
    $id_mobil = intval($_GET['id_mobil']);

    // Query untuk mendapatkan detail mobil
    $sql = "SELECT * FROM mobil WHERE id_mobil = $id_mobil";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $mobil = $result->fetch_assoc();

        // Cek status mobil, jika 'disewa' arahkan ke halaman booking
        if ($mobil['status'] === 'disewa') {
            echo "<script>alert('Mobil sedang disewa. Silakan pilih mobil lain.');</script>";
            echo "<script>window.location.href = 'booking.php';</script>";
            exit;
        }
    } else {
        echo "Mobil tidak ditemukan!";
        exit;
    }
} else {
    echo "ID mobil tidak valid!";
    exit;
}

// Jika form booking dikirimkan
$bookingSukses = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];
    $tujuan_rental = $_POST['tujuan_rental'];
    $tujuan_rental_lainnya = $tujuan_rental === 'lainnya' ? $_POST['tujuan_rental_lainnya'] : null;
    $alamat_tujuan = $_POST['alamat_tujuan'];

    // Validasi tanggal
    if (strtotime($tanggal_mulai) >= strtotime($tanggal_berakhir)) {
        echo "<script>alert('Tanggal mulai harus lebih awal dari tanggal berakhir!');</script>";
    } elseif ($tujuan_rental === 'lainnya' && empty($tujuan_rental_lainnya)) {
        echo "<script>alert('Silakan isi tujuan lainnya jika memilih lainnya!');</script>";
    } else {
        // Hitung durasi dan total harga
        $durasi = (strtotime($tanggal_berakhir) - strtotime($tanggal_mulai)) / (60 * 60 * 24);
        $harga_total = $durasi * $mobil['harga_sewa'];

        // Masukkan data ke tabel rental_pemesanan
        $sql_insert = "INSERT INTO rental_pemesanan (id_pelanggan, id_mobil, tanggal_pemesanan, tanggal_mulai, tanggal_berakhir, harga_total, tujuan_rental, tujuan_rental_lainnya, alamat_tujuan)
                       VALUES ($id_pelanggan, $id_mobil, CURDATE(), '$tanggal_mulai', '$tanggal_berakhir', $harga_total, '$tujuan_rental', '$tujuan_rental_lainnya', '$alamat_tujuan')";

        if ($conn->query($sql_insert)) {
            // Ambil id_pemesanan yang baru saja dimasukkan
            $id_pemesanan = $conn->insert_id;

            // Tambahkan data ke tabel list_pemesanan
            $sql_insert_list_pemesanan = "INSERT INTO list_pemesanan (id_pemesanan, id_supir, status)
                                          VALUES ($id_pemesanan, NULL, 'belum bayar')";

            if ($conn->query($sql_insert_list_pemesanan)) {
                // Ubah status mobil menjadi "disewa"
                $conn->query("UPDATE mobil SET status = 'disewa' WHERE id_mobil = $id_mobil");

                // Booking sukses
                $bookingSukses = true;
            } else {
                echo "Terjadi kesalahan saat menambahkan ke list_pemesanan: " . $conn->error;
            }
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"> <!-- Flatpickr -->
    <link rel="stylesheet" href="css/booking_proses.css">
    <script>
        function toggleLainnya(value) {
            const lainnyaField = document.getElementById('tujuan_rental_lainnya_container');
            if (value === 'lainnya') {
                lainnyaField.style.display = 'block';
            } else {
                lainnyaField.style.display = 'none';
            }
        }
    </script>
</head>

<body style="background: url('../img/image.jpg') no-repeat center center; background-size: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 1); min-height: 300px;">
    <div class="container-fluid justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="justify-content-center align-items-center col-12">
                <h1 class="text-center mt-4" style="color:white"><strong>Proses Booking Mobil</strong></h1>
            </div>
            <form method="POST">
                <div class="booking-container row justify-content-center" style="border-radius: 50px;">
                    <!-- Informasi Mobil -->
                    <div class="card align-items-center" style="border-radius: 50px;">
                        <img src="../img/mobil/<?= $mobil['mobil_foto']; ?>" class="card-img-top mt-3 mb-3" alt="<?= $mobil['merek']; ?>">
                    </div>
                    <div class="info col-md-6 col-sm-12 mb-3" style="border-radius: 50px;">
                        <h2><?= $mobil['merek'] . ' ' . $mobil['model']; ?></h2>
                        <p><strong>Kapasitas Penumpang:</strong> <?= $mobil['kapasitas_penumpang']; ?></p>
                        <p><strong>Tahun Produksi:</strong> <?= $mobil['tahun_produksi']; ?></p>
                        <p><strong>Warna:</strong> <?= $mobil['warna']; ?></p>
                        <p><strong>Harga Sewa:</strong> Rp <?= number_format($mobil['harga_sewa'], 2, ',', '.'); ?>/Hari</p>
                        <a><strong>deskripsi:</strong>
                            <p><?= $mobil['deskripsi'] ?></p>
                        </a>
                    </div>

                    <!-- Ringkasan Booking -->
                    <div class="booking-summary col-md-8 col-sm-12 mb-3" style="border-radius: 50px;">
                        <label>Tanggal Mulai</label>
                        <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-3" placeholder="Masukkan tanggal mulai" required>

                        <label>Tanggal Berakhir</label>
                        <input type="text" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control mb-3" placeholder="Masukkan tanggal berakhir" required>

                        <label>Alamat Tujuan</label>
                        <input type="text" name="alamat_tujuan" class="form-control mb-3" placeholder="Masukkan alamat tujuan" required>

                        <label>Tujuan Rental</label>
                        <select name="tujuan_rental" class="form-select" onchange="toggleLainnya(this.value)" required>
                            <option value="wisata">Wisata</option>
                            <option value="keperluan bisnis">Keperluan Bisnis</option>
                            <option value="pernikahan">Pernikahan</option>
                            <option value="pesta">Pesta</option>
                            <option value="lainnya">Lainnya</option>
                        </select>

                        <div id="tujuan_rental_lainnya_container" style="display: none;">
                            <label>Tuliskan Tujuan</label>
                            <input type="text" name="tujuan_rental_lainnya" class="form-control">
                        </div>

                        <p class="mt-3 mb-3" id="harga_total">Rp 0</p>
                        <button type="submit" class="btn btn-success col-12">Booking</button>
                        <a href="booking.php" class="btn btn-danger mt-1 col-12">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pop-up Booking Sukses -->
    <div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Sukses!</h5>
                </div>
                <div class="modal-body">
                    Terima kasih, booking mobil Anda telah berhasil! Anda akan diarahkan ke halaman utama.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tanggal_mulai", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });
        flatpickr("#tanggal_berakhir", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });

        const hargaSewa = <?= $mobil['harga_sewa']; ?>;

        document.querySelectorAll("#tanggal_mulai, #tanggal_berakhir").forEach(input => {
            input.addEventListener("change", () => {
                const mulai = new Date(document.getElementById("tanggal_mulai").value);
                const berakhir = new Date(document.getElementById("tanggal_berakhir").value);
                if (mulai < berakhir) {
                    const durasi = (berakhir - mulai) / (1000 * 60 * 60 * 24);
                    document.getElementById("harga_total").innerText = `Rp ${(durasi * hargaSewa).toLocaleString()}`;
                }
            });
        });

        <?php if ($bookingSukses): ?>
            var bookingModal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
            bookingModal.show();
            setTimeout(() => window.location.href = 'index.php', 3000);
        <?php endif; ?>
    </script>
</body>

</html>