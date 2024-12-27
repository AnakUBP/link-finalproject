<?php
session_start();
require 'fungsi/db.php'; // File konfigurasi koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun']) || !isset($_SESSION['peran'])) {
  header('Location: login.php');
  exit();
}

// Periksa peran pengguna
$peran = $_SESSION['peran'];
if ($peran !== 'admin' && $peran !== 'super admin') {
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin dan super admin.'); window.location = 'login.php';</script>";
  exit();
}
// Tangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['submit_kategori_mobil'])) {
    // Menangani pembuatan kategori mobil
    $nama_kategori = $_POST['nama_kategori'];
    $jangkauan_kapasitas_penumpang = $_POST['jangkauan_kapasitas_penumpang'];
    $deskripsi = $_POST['deskripsi'];

    // Query untuk menambahkan kategori mobil
    $query = "INSERT INTO kategori_mobil (nama_kategori, jangkauan_kapasitas_penumpang, deskripsi) 
                  VALUES ('$nama_kategori', '$jangkauan_kapasitas_penumpang', '$deskripsi')";
    if ($conn->query($query) === TRUE) {
      echo "<script>alert('Kategori Mobil berhasil ditambahkan!');</script>";
    } else {
      echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
  } elseif (isset($_POST['submit_mobil'])) {
    // Menangani pembuatan mobil
    $id_kategori = $_POST['id_kategori'];
    $plat_nomor = $_POST['plat_nomor'];
    $merek = $_POST['merek'];
    $model = $_POST['model'];
    $tahun_produksi = $_POST['tahun_produksi'];
    $warna = $_POST['warna'];
    $kapasitas_penumpang = $_POST['kapasitas_penumpang'];
    $harga_sewa = $_POST['harga_sewa'];

    // Mengupload file gambar mobil
    $target_dir = "../img/mobil/";
    $target_file = $target_dir . basename($_FILES["mobil_foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar adalah gambar yang sebenarnya
    if (isset($_POST["submit_mobil"])) {
      $check = getimagesize($_FILES["mobil_foto"]["tmp_name"]);
      if ($check === false) {
        echo "<script>alert('File yang diunggah bukan gambar.');</script>";
        $uploadOk = 0;
      }
    }

    // Cek jika file sudah ada
    if (file_exists($target_file)) {
      echo "<script>alert('Maaf, file sudah ada.');</script>";
      $uploadOk = 0;
    }

    // Batasi ukuran file
    if ($_FILES["mobil_foto"]["size"] > 5000000) { // 5MB
      echo "<script>alert('Maaf, file terlalu besar.');</script>";
      $uploadOk = 0;
    }

    // Batasi format file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "<script>alert('Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
      $uploadOk = 0;
    }

    // Jika $uploadOk = 0, tidak melakukan upload
    if ($uploadOk == 0) {
      echo "<script>alert('Maaf, file tidak dapat diunggah.');</script>";
    } else {
      // Jika semuanya oke, upload file
      if (move_uploaded_file($_FILES["mobil_foto"]["tmp_name"], $target_file)) {
        echo "<script>alert('File " . htmlspecialchars(basename($_FILES["mobil_foto"]["name"])) . " telah diunggah.');</script>";

        // Menyimpan data mobil ke database
        $mobil_foto = basename($_FILES["mobil_foto"]["name"]);
        $query = "INSERT INTO mobil (id_kategori, plat_nomor, merek, model, tahun_produksi, warna, kapasitas_penumpang, harga_sewa, mobil_foto) 
                          VALUES ('$id_kategori', '$plat_nomor', '$merek', '$model', '$tahun_produksi', '$warna', '$kapasitas_penumpang', '$harga_sewa', '$mobil_foto')";
        if ($conn->query($query) === TRUE) {
          echo "<script>alert('Mobil berhasil ditambahkan!');</script>";
        } else {
          echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
      } else {
        echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file.');</script>";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
  <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <script>
    function toggleForm(formType) {
      if (formType === 'kategori') {
        document.getElementById('kategoriForm').style.display = 'block';
        document.getElementById('mobilForm').style.display = 'none';
        document.getElementById('mobilList').style.display = 'none';
      } else {
        document.getElementById('mobilForm').style.display = 'block';
        document.getElementById('kategoriForm').style.display = 'none';
        document.getElementById('mobilList').style.display = 'none';
      }
    }

    function showMobilList() {
      document.getElementById('mobilList').style.display = 'block';
      document.getElementById('kategoriForm').style.display = 'none';
      document.getElementById('mobilForm').style.display = 'none';
    }
  </script>
</head>


<body>
  <?php include('include/sidebar.php') ?>
  <div class="container mt-5">
    <h1 class="text-center">Rental Mobil</h1>

    <div class="text-center">
      <button class="btn btn-primary" onclick="toggleForm('kategori')">Buat Kategori Mobil</button>
      <button class="btn btn-primary" onclick="toggleForm('mobil')">Buat Mobil</button>
      <button class="btn btn-primary" onclick="showMobilList()">Lihat Semua Mobil</button>
    </div>

    <!-- Form Kategori Mobil -->
    <div id="kategoriForm" style="display:none; margin-top: 30px;">
      <h3>Buat Kategori Mobil</h3>
      <form method="POST">
        <div class="form-group">
          <label for="nama_kategori">Nama Kategori</label>
          <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
        </div>
        <div class="form-group">
          <label for="jangkauan_kapasitas_penumpang">Jangkauan Kapasitas Penumpang</label>
          <input type="text" class="form-control" id="jangkauan_kapasitas_penumpang" name="jangkauan_kapasitas_penumpang">
        </div>
        <div class="form-group">
          <label for="deskripsi">Deskripsi</label>
          <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
        </div>
        <button type="submit" name="submit_kategori_mobil" class="btn btn-success">Tambah Kategori</button>
      </form>
    </div>

    <!-- Form Mobil -->
    <div id="mobilForm" style="display:none; margin-top: 30px;">
      <h3>Buat Mobil</h3>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="id_kategori">Pilih Kategori Mobil</label>
          <select class="form-control" id="id_kategori" name="id_kategori" required>
            <?php
            // Ambil data kategori mobil
            $result = $conn->query("SELECT * FROM kategori_mobil");
            while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row['id_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="plat_nomor">Plat Nomor</label>
          <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" required>
        </div>
        <div class="form-group">
          <label for="merek">Merek</label>
          <input type="text" class="form-control" id="merek" name="merek" required>
        </div>
        <div class="form-group">
          <label for="model">Model</label>
          <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="form-group">
          <label for="tahun_produksi">Tahun Produksi</label>
          <input type="number" class="form-control" id="tahun_produksi" name="tahun_produksi" required>
        </div>
        <div class="form-group">
          <label for="warna">Warna</label>
          <input type="text" class="form-control" id="warna" name="warna" required>
        </div>
        <div class="form-group">
          <label for="kapasitas_penumpang">Kapasitas Penumpang</label>
          <input type="number" class="form-control" id="kapasitas_penumpang" name="kapasitas_penumpang" required>
        </div>
        <div class="form-group">
          <label for="harga_sewa">Harga Sewa</label>
          <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" required>
        </div>
        <div class="form-group">
          <label for="mobil_foto">Foto Mobil</label>
          <input type="file" class="form-control-file" id="mobil_foto" name="mobil_foto" required>
        </div>
        <button type="submit" name="submit_mobil" class="btn btn-success">Tambah Mobil</button>
      </form>
    </div>
    <div id="mobilList" style="display:none; margin-top: 30px;">
      <?php
      // Query utama untuk mengambil mobil dengan kategori
      $sql = "
        SELECT m.*, k.nama_kategori, k.jangkauan_kapasitas_penumpang
        FROM mobil m
        LEFT JOIN kategori_mobil k ON m.id_kategori = k.id_kategori
        ORDER BY k.nama_kategori IS NULL, k.nama_kategori, m.merek
    ";
      $result = $conn->query($sql);
      ?>
      <?php
      if ($result && $result->num_rows > 0):
        $current_category = null;
        while ($row = $result->fetch_assoc()):
          // Kategori lainnya untuk id_kategori NULL
          $category_name = $row['nama_kategori'] ?? 'Kategori Lainnya';
          $capacity_range = $row['jangkauan_kapasitas_penumpang'] ?? 'Tidak Ditentukan';

          if ($current_category !== $category_name):
            if ($current_category !== null): ?>
    </div> <!-- Tutup row sebelumnya -->
  <?php endif; ?>
  <h3 class="mt-5 d-flex justify-content-between align-items-center">
    <div>
      <?= $category_name; ?>
      <small class="text-muted">(<?= $capacity_range; ?>)</small>
    </div>
    <?php if ($row['id_kategori']): ?>
      <!-- Tombol Edit dan Hapus Kategori -->
      <div>
        <a href="./edit_kategori.php?id_kategori=<?= $row['id_kategori']; ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-edit"></i> Edit
        </a>
        <a href="./delete_kategori.php?id_kategori=<?= $row['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
          <i class="fas fa-trash"></i> Hapus
        </a>
      </div>
    <?php endif; ?>
  </h3>
  <div class="row">
    <?php $current_category = $category_name; ?>
  <?php endif; ?>

  <!-- Card untuk setiap mobil -->
  <div class="col-lg-4">
    <div class="card mb-4">
      <img src="../img/mobil/<?= $row['mobil_foto']; ?>" class="card-img-top" alt="<?= $row['merek']; ?>">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-car"></i> <?= $row['merek'] . ' ' . $row['model']; ?></h5>
        <p class="card-text">
          <strong>Plat Nomor:</strong> <?= $row['plat_nomor']; ?><br>
          <strong>Tahun:</strong> <?= $row['tahun_produksi']; ?><br>
          <strong>Warna:</strong> <?= $row['warna']; ?><br>
          <strong>Kapasitas Penumpang:</strong> <?= $row['kapasitas_penumpang']; ?> orang<br>
          <strong>Harga Sewa:</strong> Rp <?= number_format($row['harga_sewa'], 2, ',', '.'); ?><br>
          <strong>Status:</strong> <?= ucfirst($row['status']); ?>
        </p>
        <!-- Tombol Edit dan Hapus Mobil -->
        <a href="./edit_mobil.php?id_mobil=<?= $row['id_mobil']; ?>" class="btn btn-warning">
          <i class="fas fa-edit"></i> Edit
        </a>
        <a href="./delete_mobil.php?id_mobil=<?= $row['id_mobil']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini? (mobil akan terhapus secara permanen jika status mobil berada pada berakhir)')">
          <i class="fas fa-trash"></i> berakhir/hapus
        </a>
      </div>
    </div>
  </div>
<?php endwhile; ?>
  </div> <!-- Tutup row terakhir -->
<?php endif; ?>
  </div>


  </div>
  </div>
  </div>

  </div>
</body>

</html>