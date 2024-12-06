<?php
require_once 'fungsi/db.php';

session_start();
$idAkun = $_SESSION['id_akun'] ?? null;

if (!$idAkun) {
    header('Location: register.php'); // Redirect jika sesi tidak valid
    exit;
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = $_POST['alamat'];
    $noTelepon = $_POST['no_telepon'];

    // Validasi input
    if (empty($alamat) || empty($noTelepon)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        // Insert ke tabel pelanggan
        $queryInsert = "INSERT INTO pelanggan (id_akun, alamat, no_telepon) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bind_param('iss', $idAkun, $alamat, $noTelepon);

        if ($stmtInsert->execute()) {
            $success = true;
            unset($_SESSION['id_akun']); // Hapus sesi setelah berhasil
            header('Location: login.php');
            exit;
        } else {
            $error = "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>complete_profile</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Lengkapi Profil</h4>
          </div>
          <div class="card-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
              </div>
              <div class="form-group">
                <label for="no_telepon">Nomor Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
