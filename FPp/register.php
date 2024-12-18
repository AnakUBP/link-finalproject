<?php
include ('fungsi/db.php'); // Pastikan ini mengarah ke file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah ada
    $query = "SELECT * FROM akun WHERE email = ? OR nama_pengguna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika sudah ada, beri pesan error
        $error = "Username atau email sudah digunakan.";
    } else {
        // Masukkan data ke tabel akun
        $query = "INSERT INTO akun (nama_pengguna, email, kata_sandi, peran) VALUES (?, ?, ?, 'pelanggan')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $password_hash);
        $stmt->execute();

        // Ambil id_akun yang baru saja dibuat
        $id_akun = $stmt->insert_id;

        // Masukkan data ke tabel pelanggan
        $query = "INSERT INTO pelanggan (id_akun, nama_lengkap) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $id_akun, $nama_lengkap);
        if ($stmt->execute()) {
            $success = true;
            header('Location: login.php');
        } else {
            $error = "Gagal menyimpan data pelanggan.";
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
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
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
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
              </form>
              <div class="text-center mt-3">
                <p>Sudah memiliki akun? <b><a href="login.php" class="btn btn-primary">Login</a></b></p>
                <b><a href="index.php" class="btn btn-primary">kembali</a></b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
