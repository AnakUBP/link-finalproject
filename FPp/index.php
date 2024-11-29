<?php
require 'fungsi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $merk = $_POST['merk'];
  $tahun_produksi = $_POST['tahun_produksi'];
  $role = $_POST['kategori'];
  $maxFileSize = 50 * 1024 * 1024; // 50MB in bytes
  
    if (!isset($error)) {
      $stmt = $pdo->prepare("INSERT INTO garage (nama, merk, tahun_produksi, role, foto) VALUES (?, ?, ?, ?, ?,)");
      if ($stmt->execute([$nama, $merk, $tahun_produksi, $role, $foto])) {
        $success = "berhasil ditambahkan <a href='login.php' class='btn btn-warning'>LOGIN</a>.";
      } else {
        $error = "Terjadi kesalahan";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>

  <!-- Bootstrap -->
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom CSS -->
  <style>
    a {
      color: azure !important;
      /* Memastikan semua link memiliki warna dark */
    }

    .carousel-caption h5 {
      background-color: rgba(255, 255, 255, 0.7);
      /* Putih dengan transparansi 70% */
      border-radius: 20px;
      padding: 10px 20px;
      display: inline-block;
      /* Agar ukuran sesuai dengan konten */
    }

    .card {
      border-radius: 20px;
    }

    h5 {
      color: black;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><i class="fa-solid fa-"></i> BUROQ TRANSPORT</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-info-circle"></i> About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="fas fa-user-edit"></i></i> Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Carousel -->
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/KonoSuba Season 3.jpeg" class="d-block w-100" alt="slide pertama">
        <div class="carousel-caption d-none d-md-block">
          <h5>Selamat datang di website Buroq Trasnport</h5>
          <p class="text-primary font-weight-bold">Melayani Ke Seluruh Penjuru Indonesia</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="img/IFD(1).jpg" class="d-block w-100" alt="slide ke 2">
        <div class="carousel-caption d-none d-md-block">
          <h5>Professional Team</h5>
        </div>
      </div>
      <div class="carousel-item">
        <img src="img/KonoSuba Season 3.jpg" class="d-block w-100" alt="slide ke 3">
        <div class="carousel-caption d-none d-md-block">
          <h5>Contact Us Today</h5>
          <p class="text-primary font-weight-bold">We are here to assist you with any inquiries.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <!-- Features Section -->
  <div class="container my-5">
    <div class="row text-center">
      <div class="col-lg-4">
        <i class="fas fa-bolt fa-3x mb-4"></i>
        <h3>Fast</h3>
        <p>Our services are optimized for speed and efficiency.</p>
      </div>
      <div class="col-lg-4">
        <i class="fas fa-shield-alt fa-3x mb-4"></i>
        <h3>Secure</h3>
        <p>We use the latest security technologies to keep your data safe.</p>
      </div>
      <div class="col-lg-4">
        <i class="fas fa-users fa-3x mb-4"></i>
        <h3>Support</h3>
        <p>Our team is here to help you 24/7 with any issues.</p>
      </div>
    </div>
  </div>

  <!-- Card Section -->
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <img src="img/suzuki carry.jpg" class="card-img-top" alt="gambar pretama">
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-car"></i> Suzuki carry</h5>
            <p class="card-text">pick-up</p>
            <a href="#" class="btn alert-primary"><i class="fas fa-arrow-right"></i> Lihat lebih lanjut</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card mb-4">
          <img src="img/xpander.jpg" class="card-img-top" alt="gambar ke 2">
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-car"></i> Mitsubishi xpander</h5>
            <p class="card-text">mobil pribadi</p>
            <a href="#" class="btn alert-warning"><i class="fas fa-arrow-right"></i> Lihat lebih lanjut</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card mb-4">
          <img src="img/KonoSuba Season 3.jpeg" class="card-img-top" alt="gambar ke 3">
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-cogs"></i> Service 3</h5>
            <p class="card-text">We offer tailored service 3 for your specific needs.</p>
            <a href="#" class="btn alert-warning"><i class="fas fa-arrow-right"></i> Learn More</a>
          </div>
        </div>
      </div>
    </div>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1>Tambah Kendaraan Baru</h1>
        <form action="proses_tambah_kendaraan.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kendaraan</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe Kendaraan</label>
                <input type="text" class="form-control" id="tipe" name="tipe" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kendaraan</button>
        </form>
    </div>
</body>
</html>

  </div>

  <!-- Footer -->

  <footer>
    <style>
      footer {
        background-color: black;
        /* Warna latar belakang footer */
        padding: 20px 0;
        /* Tambahkan padding untuk footer */
      }
    </style>
    <div class="container text-center py-4">
      <p class="mb-0">&copy; 2024 Buroq Trasnport. All Rights Reserved.</p>
      <div class="social-icons mt-3">
        <a href="#" class="mx-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>