<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supir</title>
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
      .container p {
      color: #4B569F;
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
        background-color: #4B569F;
        color: #fff;
        font-weight: 600;
    }

    tr:hover {
        background-color: #f1f1f1;
        transition: background-color 0.3s;
    }

    form {
        background-color: white;
        padding: 25px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        border-radius: 8px;
        margin: 10px;
    }

    form div {
        margin-bottom: 5px;
    }

    form label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: black;
    }

    form input, form select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 14px;
        color: #333;
    }

    form input:focus, form select:focus {
        border-color: #5dade2;
        outline: none;
        box-shadow: 0 0 4px rgba(93, 173, 226, 0.5);
    }

    form button {
        padding: 12px 20px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;

    }

    form button:hover {
        background-color: #218838;
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
                    <a class="nav-link" href="admin_dashboard.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/data_kendaraan.php"><i class="fas fa-car fa-lg"></i> Data Kendaraan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Data Supir</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Supir</th>
                    <th>ID Akun</th>
                    <th>No SIM</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Jumlah Ulasan</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_supir']; ?></td>
                            <td><?= $row['id_akun']; ?></td>
                            <td><?= $row['no_sim']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['rating']; ?></td>
                            <td><?= $row['jumlah_ulasan']; ?></td>
                            <td><img src="<?= $row['foto']; ?>" alt="foto" width="100"></td>
                            <td>
                                <a href="edit_supir.php?id=<?= $row['id_supir']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_supir.php?id=<?= $row['id_supir']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data supir ini?');">Hapus</a>
                                <a href="rate_supir.php?id=<?= $row['id_supir']; ?>" class="btn btn-primary btn-sm">Beri Rating</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data supir.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-4">
        <h2>Tambah Data Supir</h2>
        <form action="backend/tambah_supir.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="id_supir">ID Supir:</label>
                <input type="number" id="id_supir" name="id_supir" required>
            </div>
            <div>
                <label for="id_akun">ID Akun:</label>
                <input type="number" id="id_akun" name="id_akun" required>
            </div>
            <div>
                <label for="no_sim">No SIM:</label>
                <input type="text" id="no_sim" name="no_sim" required>
            </div>
            <div>
                <label for="gambar">Upload Gambar</label>
                <input type="file" id="gambar" name="gambar" required>
            </div>
            <button type="submit">Tambah Supir</button>
        </form>
    </div>
    <footer>
        <div class="container text-center py-5 mt-5">
            <p class="mb-0">&copy; 2024 Buroq Transport. All Rights Reserved.</p>
            <div class="social-icons mt-3">
                <a href="https://web.facebook.com/syandila.syandila.56/" class="mx-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="mx-2"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/@albedo1128?lang=id-ID" class="mx-2"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>