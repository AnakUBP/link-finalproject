<?php
session_start();
require 'database/db.php'; // File konfigurasi koneksi database

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

// Query untuk mengambil penghasilan per bulan
$query = "
    SELECT 
        DATE_FORMAT(tanggal_pemesanan, '%Y-%m') AS bulan,
        SUM(harga_total) AS total_penghasilan
    FROM rental_pemesanan
    GROUP BY bulan
    ORDER BY bulan ASC
";

$result = $conn->query($query);

$bulan = [];
$penghasilan = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bulan[] = $row['bulan']; // Contoh: '2024-01'
        $penghasilan[] = $row['total_penghasilan'];
    }
}

// Konversi data ke format JSON untuk Chart.js
$bulan_json = json_encode($bulan);
$penghasilan_json = json_encode($penghasilan);
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
</head>
<?php
include('include/sidebar.php')
?>

<body style="background-color:whitesmoke">
    <div id="main-content">
        <h1 class="text-center" style="color:black">Dashboard Admin</h1>
        <p class="text-center">Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama_pengguna']); ?></strong>. Anda login sebagai <strong><?= htmlspecialchars($_SESSION['peran']); ?></strong>.</p>

        <div class="row">
            <div class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Grafik Penghasilan Bulanan
                    </div>
                    <div class="card-body">
                        <canvas id="penghasilanChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Kode JavaScript untuk Chart.js (seperti sebelumnya)
        const bulan = <?php echo $bulan_json; ?>;
        const penghasilan = <?php echo $penghasilan_json; ?>;

        const ctx = document.getElementById('penghasilanChart').getContext('2d');
        const penghasilanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Penghasilan Bulanan (Rp)',
                    data: penghasilan,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Penghasilan (Rp)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>