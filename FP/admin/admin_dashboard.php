<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header('Location: ../backend/login.php');
//     exit;
// }

// require '../database/db.php';
// $users = mysqli_query($db_connect, "SELECT * FROM users");
// $no = 1;

// function getPendapatan($conn, $startDate, $endDate) {
//   $sql = "SELECT SUM(jumlah) as total FROM pendapatan WHERE tanggal BETWEEN ? AND ?";
//   $stmt = $conn->prepare($sql);
//   $stmt->bind_param("ss", $startDate, $endDate);
//   $stmt->execute();
//   $result = $stmt->get_result();
//   $row = $result->fetch_assoc();
//   return $row['total'] ?? 0;
// }


// // Pendapatan Harian
// $today = date("Y-m-d");
// $pendapatanHarian = getPendapatan($conn, $today, $today);

// // Pendapatan Mingguan
// $startOfWeek = date("Y-m-d", strtotime("last sunday"));
// $pendapatanMingguan = getPendapatan($conn, $startOfWeek, $today);

// // Pendapatan Bulanan
// $startOfMonth = date("Y-m-01");
// $pendapatanBulanan = getPendapatan($conn, $startOfMonth, $today);

// // Pendapatan Tahunan
// $startOfYear = date("Y-01-01");
// $pendapatanTahunan = getPendapatan($conn, $startOfYear, $today);

?>

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
      background-color: #ffffff;
      background-image: url('img/KonoSuba Season 3.jpeg');
      background-size: cover;
      background-repeat: no-repeat;
      color: #4B569F;
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      font-family: Arial, sans-serif;
    }
    .card-custom {
      background: #3E4687;
      color: white;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .card-custom h3 {
      font-size: 2rem;
      margin: 0;
    }
    .card-custom i {
      font-size: 1.5rem;
    }
    .card-custom .icon-bg {
      background: rgba(255, 255, 255, 0.2);
      padding: 12px;
      border-radius: 50%;
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
    </style>

</head>
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
        <a class="nav-link" href="../view/data_kendaraan.php"><i class="fas fa-info-circle"></i> view</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../admin/supir.php"><i class="fas fa-concierge-bell"></i> Supir</a>
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
<div class="container mt-5">
        <div class="row g-4">
            <!-- Pendapatan Harian -->
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Pendapatan Hari Ini</h5>
                            <h3>Rp<?= number_format($pendapatanHarian, 0, ',', '.') ?></h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pendapatan Mingguan -->
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Pendapatan Minggu Ini</h5>
                            <h3>Rp<?= number_format($pendapatanMingguan, 0, ',', '.') ?></h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pendapatan Bulanan -->
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Pendapatan Bulan Ini</h5>
                            <h3>Rp<?= number_format($pendapatanBulanan, 0, ',', '.') ?></h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pendapatan Tahunan -->
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Pendapatan Tahun Ini</h5>
                            <h3>Rp<?= number_format($pendapatanTahunan, 0, ',', '.') ?></h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik atau Rincian -->
        <div class="mt-5">
            <h3 class="mb-4">Grafik Pendapatan</h3>
            <div class="bg-white p-4 rounded shadow">
                <!-- Area Chart Placeholder -->
                <canvas id="pendapatanChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pendapatanChart').getContext('2d');
        const pendapatanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: [120000, 1350000, 1500000, 1800000, 2000000, 2200000, 2500000, 2700000, 3000000, 3200000, 3500000, 4000000],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

  <!-- Footer -->
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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>