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
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      margin: 0;
      padding: 0;
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
      max-width: 600px;
      margin: 50px auto;
      margin-top: 90px;
      background: #ffffff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      padding: 20px;

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
      background-color: #80bdff;
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
        <a class="nav-link" href="../index.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../about.php"><i class="fas fa-info-circle"></i> About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../services.php"><i class="fas fa-concierge-bell"></i> Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../contact.php"><i class="fas fa-envelope"></i> Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../login.php"><i class="fas fa-user-edit"></i> Login</a>
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

  <footer>
    <style>
      footer {
        background-color: white;
        padding: 20px 0;
      }
    </style>

    <div class="container1 text-center py-4">
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