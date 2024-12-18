<?php
session_start();
include 'fungsi/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<?php
  if (!isset($_SESSION['id_akun'])) {
    include('includes/headera.php');
?>
    <div class="container mb-5">
      <h1 class="text-center mt-5 mb-5">Selamat Datang di Buroq Rental Mobil</h1>
      <p class="text-center mt-3 mb-4">Silakan login atau daftar untuk menggunakan layanan kami.</p>

      <div class="d-flex justify-content-center gap-4">
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="register.php" class="btn btn-secondary">Daftar</a>
      </div>
    </div>
<?php
  } else {
    include('includes/header.php');
    $id_akun = $_SESSION['id_akun'];

    // Ambil data akun dan profil pelanggan
    $sql = "SELECT * FROM akun JOIN pelanggan ON akun.id_akun = pelanggan.id_akun WHERE akun.id_akun = '$id_akun'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Ambil riwayat pemesanan
    $sql_pemesanan = "SELECT rp.tanggal_pemesanan, rp.tanggal_mulai, rp.tanggal_berakhir, 
                      m.merek AS mobil, m.model, m.harga_sewa, 
                      lp.status AS status_pembayaran, lp.bukti_pembayaran, 
                      lp.status AS status_pemesanan
                      FROM rental_pemesanan rp
                      JOIN list_pemesanan lp ON rp.id_pemesanan = lp.id_pemesanan
                      JOIN mobil m ON rp.id_mobil = m.id_mobil
                      WHERE rp.id_pelanggan = '$id_akun'
                      ORDER BY rp.tanggal_pemesanan DESC";
    $result_pemesanan = $conn->query($sql_pemesanan);
?>

    <div class="container mb-5">
      <h2>Hello <?php echo $user['nama_pengguna']; ?></h2>
    </div>
    <div class="col-8">
      <div class="card">
        <div class="card-header">
          <h5 class="text-center">Riwayat Pemesanan</h5>
        </div>
        <div class="card-body">
          <?php if ($result_pemesanan->num_rows > 0): ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th>Tanggal Pemesanan</th>
                <th>Mobil</th>
                <th>Status Pembayaran</th>
                <th>Status Pemesanan</th>
                <th>Aksi</th> <!-- Tambahkan kolom aksi -->
              </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php while ($pemesanan = $result_pemesanan->fetch_assoc()): ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $pemesanan['tanggal_pemesanan']; ?></td>
              <td><?php echo $pemesanan['merek'] . " " . $pemesanan['model']; ?></td>
              <td><?php echo $pemesanan['status_pembayaran']; ?></td>
              <td><?php echo $pemesanan['status_pemesanan']; ?></td>
              <td>
                <a href="list_pemesanan.php?id_pemesanan=<?php echo $pemesanan['id_pemesanan']; ?>" class="btn btn-info btn-sm">Lihat Detail</a>
              </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
          <?php else: ?>
            <p>Tidak ada riwayat pemesanan.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="text-center mt-2">
      <a href="booking.php" class="btn btn-primary">Buat Pemesanan Baru</a>
    </div>
<?php
  }
?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- Features Section -->
<div class="container">
  <div class="row text-center mt-5">
    <div class="col-lg-4">
      <i class="fas fa-bolt fa-3x mb-2"></i>
      <h3>Fast</h3>
      <p>Our services are optimized for speed and efficiency.</p>
    </div>
    <div class="col-lg-4">
      <i class="fas fa-shield-alt fa-3x mb-2"></i>
      <h3>Secure</h3>
      <p>We use the latest security technologies to keep your data safe.</p>
    </div>
    <div class="col-lg-4">
      <i class="fas fa-users fa-3x mb-2"></i>
      <h3>Support</h3>
      <p>Our team is here to help you 24/7 with any issues.</p>
    </div>
  </div>
</div>
<?php
  include ('includes/footer.php')
?>
</body>
</html>
