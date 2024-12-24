<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Buroq Transport</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
    body {
        font: bold;
        margin-top: 50px;
        background-color: #eef2f7;
        color: #333;
    }

   h1{
    color: #4B569F;
    font-weight: bold;
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
    .container {
        max-width: 1000px;
        margin: 50px auto;
        margin-top: 90px;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 20px;

      }
    .social-icons a {
      color: #4B569F;
      font-size: 18px;
    }

    .social-icons a:hover {
      color: #3E4687;
    }
    h1, h2 {
        color: #2c3e50;
        font-weight: 600;
        margin: 10px;
    }

    table {
        color: black;
        width: 100%;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        margin: 10px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #34495e;
        color: #fff;
        font-weight: 600;
    }

    tr:hover {
        background-color: #f1f1f1;
        transition: background-color 0.3s;
    }
    h1 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #555;
      }

      label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #444;
      }

      input, select, textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
        color: #555;
      }
      button {
        width: 100%;
        padding: 10px;
        background-color: #4B569F;
        color: white ;
        font-size: 16px;
        border: none;
        border-radius: 15px;
        cursor: pointer;
      }
      .button:hover {
        color: black;
        background-color: black;
      }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="../index.php"><i class="fas fa-bus"></i> BUROQ TRANSPORT</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="../admin/admin_dashboard.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../admin/supir.php"><i class="fas fa-user-edit"></i> Supir</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container">
    <h1>Tambah Kendaraan</h1>
    <form action="tambah_kendaraan.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama">Nama Kendaraan</label>
        <input type="text" id="nama" name="nama" required>
      </div>
      <div class="mb-3">
        <label for="merk">Merk</label>
        <input type="text" id="merk" name="merk" required>
      </div>
      <div class="mb-3">
        <label for="tahun-produksi">Tahun Produksi</label>
        <input type="text" id="tahun-produksi" name="tahun produksi" required>
      </div>
      <div class="mb-3">
        <label for="kategori">Tipe Kendaraan</label>
        <select id="kategori" name="kategori" required>
          <option value="Mobil pick-up">Pick-up</option>
          <option value="Mobil pribadi">Mobil Pribadi</option>
          <option value="Bus">Bus</option>
          <option value="Mini bus">Mini Bus</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <label for="gambar">Upload Gambar</label>
        <input type="file" id="gambar" name="gambar" required>
      </div>
      <button type="submit">Tambah Kendaraan</button>
    </form>
  </div>

<div class="container mt-5">
    <h1 class="mb-4">Daftar Kendaraan</h1>
    <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Merk</th>
                <th>Tahun Produksi</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['merk']; ?></td>
                        <td><?= $row['tahun_produksi']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td><?= $row['deskripsi']; ?></td>
                        <td><img src="<?= $row['gambar']; ?>" alt="Gambar" width="100"></td>
                        <td>
                            <a href="edit_kendaraan.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_kendaraan.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kendaraan ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data kendaraan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>