<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki peran 'pelanggan'
if (!isset($_SESSION['id_akun']) || $_SESSION['peran'] !== 'pelanggan') {
    header('Location: login.php'); // Arahkan ke login jika bukan pelanggan
    exit;
}

include('fungsi/db.php');

if (isset($_GET['id_mobil'])) {
    $id_mobil = intval($_GET['id_mobil']);

    // Query untuk mendapatkan detail mobil
    $sql = "SELECT * FROM mobil WHERE id_mobil = $id_mobil";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $mobil = $result->fetch_assoc();
    } else {
        echo "Mobil tidak ditemukan!";
        exit;
    }
} else {
    echo "ID mobil tidak valid!";
    exit;
}

// Jika form booking dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];
    $tujuan_rental = $_POST['tujuan_rental'];
    $tujuan_rental_lainnya = $tujuan_rental === 'lainnya' ? $_POST['tujuan_rental_lainnya'] : null;
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $alamat_tujuan = $_post['alamat_tujuan'];

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
        $sql_insert = "INSERT INTO rental_pemesanan (id_pelanggan, id_mobil, tanggal_pemesanan, tanggal_mulai, tanggal_berakhir, harga_total, tujuan_rental, tujuan_rental_lainnya)
                       VALUES ($id_pelanggan, $id_mobil, CURDATE(), '$tanggal_mulai', '$tanggal_berakhir', $harga_total, '$tujuan_rental', '$tujuan_rental_lainnya','$alamat_tujuan')";
        if ($conn->query($sql_insert)) {
            // Ubah status mobil menjadi "disewa"
            $conn->query("UPDATE mobil SET status = 'disewa' WHERE id_mobil = $id_mobil");
            // Tambahkan script pop-up
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showBookingSuccessModal();
                    });
                </script>";
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
<div class="container-fluid justify-content-center align-items-center vh-100">
    <div class="container">
        <h1 class="text-center mt-4">Proses Booking Mobil</h1>
        <div class="booking-container row justify-content-center">
            <!-- Informasi Mobil -->
            <div class="card align-items-center">
                <img src="<?= $mobil['mobil_foto']; ?>" class="card-img-top mt-3 mb-3" alt="<?= $mobil['merek']; ?>">
            </div>
            <div class="info col-md-6 col-sm-12 mb-3">
                <h2><?= $mobil['merek'] . ' ' . $mobil['model']; ?></h2>
                <p><strong>Kapasitas Penumpang:</strong> <?= $mobil['kapasitas_penumpang']; ?></p>
                <p><strong>Tahun Produksi:</strong> <?= $mobil['tahun_produksi']; ?></p>
                <p><strong>Warna:</strong> <?= $mobil['warna']; ?></p>
                <p><strong>Harga Sewa:</strong> Rp <?= number_format($mobil['harga_sewa'], 2, ',', '.'); ?>/Hari</p>
                <p><strong>Deskripsi:</strong> <?= $mobil['deskripsi']; ?></p>
            </div>

            <!-- Ringkasan Booking -->
            <div class="booking-summary col-md-8 col-sm-12 mb-3">
                <h5>Tanggal Mulai</h5>
                <input type="text" id="tanggal_mulai" class="form-control mb-3">
                <h5>Tanggal Berakhir</h5>
                <input type="text" id="tanggal_berakhir" class="form-control mb-3">
                <h5>alamat tujuan</h5>
                <input type="text" id="alamat_tujuan" class="form-control mb-3">
                <div class="mb-3">
                    <label for="tujuan_rental" class="form-label">
                        <h5>Tujuan Rental</h5>
                    </label>
                    <select name="tujuan_rental" id="tujuan_rental" class="form-select" onchange="toggleLainnya(this.value)" required>
                        <option value="wisata">Wisata</option>
                        <option value="keperluan bisnis">Keperluan Bisnis</option>
                        <option value="pernikahan">Pernikahan</option>
                        <option value="pesta">Pesta</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3" id="tujuan_rental_lainnya_container" style="display: none;">
                    <label for="tujuan_rental_lainnya" class="form-label">
                        <h5>Tuliskan Tujuan</h5>
                    </label>
                    <input type="text" name="tujuan_rental_lainnya" id="tujuan_rental_lainnya" class="form-control">
                </div>
                <p class="total" id="harga_total">Rp 0</p>
                <button class="btn btn-success btn-finalize col-12">Booking</button>
                <a href="booking.php" class="btn btn-danger col-12 mt-2">Kembali</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Booking Sukses!</h5>
      </div>
      <div class="modal-body">
        Terima kasih, booking mobil Anda sedang diproses, mohon untuk melanjutkan ke proses pembayaran .
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="redirectButton">OK</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Pop-up Booking Sukses -->
<div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Booking Sukses!</h5>
      </div>
      <div class="modal-body">
        Terima kasih, booking mobil Anda telah berhasil! Anda akan diarahkan ke halaman utama.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="redirectButton">OK</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Harga sewa per hari
    const hargaSewaPerHari = <?= $mobil['harga_sewa']; ?>;

    // Inisialisasi flatpickr untuk input tanggal
    flatpickr("#tanggal_mulai", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    flatpickr("#tanggal_berakhir", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    // Fungsi untuk menghitung harga total
    function hitungHargaTotal() {
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        const tanggalBerakhir = document.getElementById('tanggal_berakhir').value;

        if (tanggalMulai && tanggalBerakhir) {
            const mulai = new Date(tanggalMulai);
            const berakhir = new Date(tanggalBerakhir);

            if (mulai < berakhir) {
                const durasi = (berakhir - mulai) / (1000 * 60 * 60 * 24); // Durasi dalam hari
                const totalHarga = durasi * hargaSewaPerHari;

                document.getElementById('harga_total').innerText = `Rp ${totalHarga.toLocaleString('id-ID')}`;
            } else {
                document.getElementById('harga_total').innerText = 'Rp 0';
            }
        }
    }
    // Event listener untuk input tanggal
    document.getElementById('tanggal_mulai').addEventListener('change', hitungHargaTotal);
    document.getElementById('tanggal_berakhir').addEventListener('change', hitungHargaTotal);
    
    // Fungsi menampilkan pop-up modal dan redirect ke index
    function showBookingSuccessModal() {
        // Tampilkan modal menggunakan Bootstrap
        var bookingModal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
        bookingModal.show();

        // Redirect ke halaman index setelah klik OK atau 3 detik
        document.getElementById('redirectButton').onclick = function () {
            window.location.href = 'index.php';
        };

        setTimeout(function () {
            window.location.href = 'index.php';
        }, 3000); // 3000 ms = 3 detik
    }
</script>
</body>

</html>