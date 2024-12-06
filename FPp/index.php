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
  include ('includes/headera.php')
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="box">
        <h1 class="text-center mt-5">Selamat Datang di Buroq Rental Mobil</h1>
        <p class="text-center mt-3 mb-4">Silakan login atau daftar untuk menggunakan layanan kami.</p>

        <div class="d-flex justify-content-center gap-4">
            <a href="login.php" class="btn btn-primary">Login</a>
            <a href="register.php" class="btn btn-secondary">Daftar</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
  </div>
</body>
<body>
  <?php
  include ('includes/footer.php')
  ?>
</body>
</html>