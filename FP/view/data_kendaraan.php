<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header('Location: ../backend/login.php');
//     exit;
// }

// require '../database/db.php';
// $users = mysqli_query($db_connect, "SELECT * FROM users");
// $no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Buroq Transport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
        .btn-choice {
            margin: 10px 0;
        }
        .form-container {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background-color: #fff;
        }
    </style>
</head>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../add/tambah_kendaraan.php"><i class =" fas fa-car"></i>Tambah Kendaraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Daftar Kendaraan</h1>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Merk</th>
                    <th>Tahun Produksi</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="table-body">
            <!-- Data akan dimuat di sini -->
        </tbody>
    </table>

    <script>
        function loadData() {
            const kategori = document.getElementById('kategori').value;
            fetch(`fetch_kendaraan.php?kategori=${kategori}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = ''; // Clear table
                    data.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.nama}</td>
                                <td>${item.kategori}</td>
                                <td>${item.merek}</td>
                                <td>${item.tahun}</td>
                                <td>${item.status}</td>
                                <td>Rp ${parseInt(item.harga).toLocaleString()}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                });
        }

        // Load data saat pertama kali
        window.onload = loadData;
    </script>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Footer -->
  <footer>
    <style>
      footer {
        background-color: white;
        padding: 20px 0;
      }
    </style>

    <div class="container text-center py-4">
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

