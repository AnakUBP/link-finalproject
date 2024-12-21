<?php
require "../FP/backend/register.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>

  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #eef2f7;
      background-image: url('img/KonoSuba Season 3.jpeg');
      background-size: cover;
      background-repeat: no-repeat;
      color: #4B569F;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 2000;
      background-color: #4B569F;
    }

    .navbar-brand,
    .navbar-nav .nav-link {
      color: #ffffff !important;
      font-weight: bold;
    }

    .nav-link:hover {
      color: black !important;
    }
    .navbar-brand:hover {
      color: black !important;
    }

    .registrasi-container {
      border-radius: 20px;
      background-color: #ffffff;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      padding: 20px;
      color: #ffffff;
    }

    .container {
      padding-top: 100px;
    }

    .form-group label {
      color: #4B569F;
    }
    .text-center{
      color: #4B569F;
    }

    .form-control{
      background-color: #ffffff;
      border: 2px solid #4B569F;
    }

    .card {
      background-color: #ffffff;
      border: 2px solid #4B569F;
    }

    .card-header {
      background-color: #4B569F;
      color: #ffffff;
    }

    .btn-primary {
      background-color: #4B569F;
      border: none;
    }

    .btn-primary:hover {
      background-color: #3E4687;
    }

    .btn-success{
      background-color: #4B569F;
      border: none;
    }

    .btn-success:hover {
      background-color: #3E4687;
    }

    .social-icons a {
      color: #4B569F;
      font-size: 18px;
    }

    .social-icons a:hover {
      color: #3E4687;
    }

  </style>
</head>

<body>

  <!-- Alert Scripts -->
  <?php if (isset($success) && $success): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Pendaftaran berhasil! Silakan login.',
        confirmButtonText: '<a href="login.php" style="color: white; text-decoration: none;">Login</a>'
      });
    </script>
  <?php elseif (isset($error)): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Registrasi Gagal',
        text: '<?php echo $error; ?>'
      });
    </script>
  <?php endif; ?>

    <nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#"><i class="fas fa-bus"></i> BUROQ TRANSPORT</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="services.php"><i class="fas fa-concierge-bell"></i> Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
      </li>
    </ul>
  </div>
</nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="registrasi-container">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="text-white">Register</h4>
            </div>
            <div class="card-body">
              <form method="POST" action="">
                <div class="form-group">
                  <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
              </form>
              <div class="text-center mt-3">
                <p>Sudah memiliki akun? <b><a href="login.php" class="btn btn-success">Login</a></b></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container text-center py-5 mt-5">
    <p class="mb-0">&copy; 2024 Buroq Transport. All Rights Reserved.</p>
    <div class="social-icons mt-3">
      <a href="https://web.facebook.com/syandila.syandila.56/" class="mx-2"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
      <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
      <a href="https://www.tiktok.com/@albedo1128?lang=id-ID" class="mx-2"><i class="fab fa-tiktok"></i></a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>