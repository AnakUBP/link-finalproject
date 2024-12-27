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
    <div class="container mb-5 col-10 d-flex flex-column justify-content-center align-items-center"
      style="background: url('../img/image.jpg') no-repeat center center; background-size: cover; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 1); min-height: 300px;">
      <h2 class="card text-center mt-3 mb-3" style="background-color: rgba(0,0,0, 0.5); color:whitesmoke; border-radius: 10px">Selamat Datang di Buroq Rental Mobil</h2>
      <p class="text-center mt-2 mb-4" style=" color:whitesmoke">Silakan login atau daftar untuk menggunakan layanan kami.</p>

      <div class="d-flex justify-content-center gap-5">
        <a href="login.php" class="btn btn-primary mx-1">Login</a>
        <a href="register.php" class="btn btn-secondary mx-1">Daftar</a>
      </div>
    </div>

  <?php
  } else {
    include('includes/header.php');
    $id_akun = $_SESSION['id_akun'];
    // Ambil data user
    $sql_user = "
    SELECT akun.nama_pengguna, pelanggan.id_pelanggan 
    FROM akun 
    JOIN pelanggan ON akun.id_akun = pelanggan.id_akun 
    WHERE akun.id_akun = '$id_akun'
    ";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();
    $id_pelanggan = $user['id_pelanggan'];

    // Ambil riwayat pemesanan
    $sql_pemesanan = "
    SELECT rp.id_pemesanan, rp.tanggal_pemesanan, rp.tanggal_mulai, rp.tanggal_berakhir,
           m.merek, m.model, m.harga_sewa,m.mobil_foto, lp.status
    FROM rental_pemesanan rp
    JOIN list_pemesanan lp ON rp.id_pemesanan = lp.id_pemesanan
    JOIN mobil m ON rp.id_mobil = m.id_mobil
    WHERE lp.status IN ('belum bayar', 'sudah bayar', 'berlangsung')
    ";
    $result_pemesanan = $conn->query($sql_pemesanan);
  ?>

    <div class="container" style=" margin-top: 80px; ">
      <h2 class="text-center">Hello, <?php echo htmlspecialchars($user['nama_pengguna']); ?></h2>
    </div>
    <div class="container mt-4">
      <div class="card">
        <div class="card-header">
          <h2 class="text-center">List Pemesanan</h2>
        </div>
        <?php if ($result_pemesanan->num_rows > 0): ?>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($pemesanan = $result_pemesanan->fetch_assoc()): ?>
              <div class="col-12">
                <div class="card">
                  <div class="card align-items-center">
                    <div class="card-body">
                      <img src="../img/mobil/<?= htmlspecialchars($pemesanan['mobil_foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($pemesanan['merek']); ?>">
                      <h5 class="card-title"><?php echo htmlspecialchars($pemesanan['merek'] . " " . $pemesanan['model']); ?></h5>
                      <p class="card-text">
                        <strong>Tanggal Pemesanan:</strong> <?php echo htmlspecialchars($pemesanan['tanggal_pemesanan']); ?><br>
                        <strong>Tanggal Mulai:</strong> <?php echo htmlspecialchars($pemesanan['tanggal_mulai']); ?><br>
                        <strong>Tanggal Berakhir:</strong> <?php echo htmlspecialchars($pemesanan['tanggal_berakhir']); ?><br>
                        <strong>Harga Sewa:</strong> Rp<?php echo number_format($pemesanan['harga_sewa'], 0, ',', '.'); ?><br>
                        <strong>Status:</strong> <?php echo htmlspecialchars($pemesanan['status']); ?>
                      </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                      <p class="mt-3">Klik tombol ini untuk melihat detail dan melanjutkan pembayaran</p>
                      <a href="detail_pemesanan.php?id_pemesanan=<?php echo $pemesanan['id_pemesanan']; ?>" class="btn btn-primary btn-sm col-3">Lihat Detail</a>
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
      <div class="text-center mt-5">
        <a href="booking.php" class="btn btn-primary">Buat Pemesanan Baru</a>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php
  }
  ?>

  <!-- Features Section -->
  <div class="container-fluid mb-5">
    <div id="featuresCarousel" class="carousel slide justify-content-center" data-bs-ride="carousel">
      <div class="carousel-inner text-center mt-5">
        <div class="carousel-item active">
          <i class="fas fa-bolt fa-3x mb-2"></i>
          <h3>Fast</h3>
          <p>Our services are optimized for speed and efficiency.</p>
        </div>
        <div class="carousel-item">
          <i class="fas fa-shield-alt fa-3x mb-2"></i>
          <h3>Secure</h3>
          <p>We use the latest security technologies to keep your data safe.</p>
        </div>
        <div class="carousel-item">
          <i class="fas fa-users fa-3x mb-2"></i>
          <h3>Support</h3>
          <p>Our team is here to help you 24/7 with any issues.</p>
        </div>
      </div>

      <!-- Carousel controls -->
      <button class="carousel-control-prev " type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>

      <!-- Carousel indicators -->
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
    </div>
  </div>

  <?php
  include('includes/footer.php')
  ?>
</body>

</html>