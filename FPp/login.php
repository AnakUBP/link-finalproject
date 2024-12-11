<?php
include 'fungsi/db.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = mysqli_real_escape_string($conn, $_POST['username_or_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query untuk mencari akun berdasarkan username atau email
    $sql = "SELECT * FROM akun WHERE email='$username_or_email' OR nama_pengguna='$username_or_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $row['kata_sandi'])) {
            // Simpan data session
            $_SESSION['id_akun'] = $row['id_akun'];
            $_SESSION['nama_pengguna'] = $row['nama_pengguna'];
            $_SESSION['peran'] = $row['peran'];

            // Update timestamp terakhir login
            $last_login = date("Y-m-d H:i:s");
            $update_sql = "UPDATE akun SET terakhir_login='$last_login' WHERE id_akun=" . $row['id_akun'];
            $conn->query($update_sql);

            // Arahkan ke dashboard setelah login berhasil
            header("Location: index.php");
            exit();
        } else {
            $error = "Kata sandi salah!";
        }
    } else {
        $error = "Email atau Username tidak ditemukan!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="login-container">
    <div class="card">
      <div class="card-header text-center">
        <h4>Login</h4>
      </div>

      <!-- Tampilkan pesan error jika ada -->
      <div class="text-center">
        <?php
        if (!empty($error)) {
          echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
      </div>

      <div class="card-body">
        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="username_or_email">Username or Email</label>
            <input type="text" name="username_or_email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
          <p>Belum memiliki akun? <b><a href="register.php" class="btn btn-primary">Daftar di sini</a></b></p>
        </div>
        <div class="text-center mt-3">
          <p>Lupa password? <b><a href="forgot_password.php" class="btn btn-primary">Ganti Password</a></b></p>
          <a href="index.php" class="btn btn-primary">Kembali</a>
        </div>
      </div>
    </div>
  </div>
  <?php
  include ('includes/footer.php')
  ?>
</body>

</html>
