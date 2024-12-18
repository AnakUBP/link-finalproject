<?php
session_start();
include 'fungsi/db.php';

if (!isset($_SESSION['id_akun'])) {
    header(header: "Location: login.php");
    exit();
}

$id_akun = $_SESSION['id_akun'];

// Ambil data akun dan profil pelanggan
$sql = "SELECT * FROM akun JOIN pelanggan ON akun.id_akun = pelanggan.id_akun WHERE akun.id_akun = '$id_akun'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Ambil riwayat pemesanan
$sql_pemesanan = "SELECT * FROM rental_pemesanan WHERE id_pelanggan = '$id_akun' ORDER BY tanggal_pemesanan DESC";
$result_pemesanan = $conn->query($sql_pemesanan);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pelanggan</title>
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php include 'includes/header.php'; ?>
  
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
      </div>
      <div class="col-md-9">
        <h3>halo <?php echo $user['nama_pengguna']; ?></h3>
        <div class="card">
          <div class="card-header">
            <h5>Profil Pengguna</h5>
          </div>
          <div class="card-body">
            <p><strong>Nama Lengkap:</strong> <?php echo $user['nama_lengkap']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Alamat:</strong> <?php echo $user['alamat']; ?></p>
            <p><strong>No. Telepon:</strong> <?php echo $user['no_telepon']; ?></p>
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-header">
            <h5>Riwayat Pemesanan</h5>
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
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php while ($pemesanan = $result_pemesanan->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $pemesanan['tanggal_pemesanan']; ?></td>
                  <td><?php echo $pemesanan['mobil']; ?></td>
                  <td><?php echo $pemesanan['status_pembayaran']; ?></td>
                  <td><?php echo $pemesanan['status_pemesanan']; ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
            <?php else: ?>
              <p>Tidak ada riwayat pemesanan.</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="text-center mt-4">
          <a href="buat_pemesanan.php" class="btn btn-primary">Buat Pemesanan Baru</a>
        </div>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>
</body>

</html>

<?php
$conn->close();
?>
