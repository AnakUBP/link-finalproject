<?php
require '../database/db.php';
function getPendapatan($conn, $startDate, $endDate) {
    $sql = "SELECT SUM(jumlah) as total FROM pendapatan WHERE tanggal BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

// Pendapatan Harian
$today = date("Y-m-d");
$pendapatanHarian = getPendapatan($conn, $today, $today);

// Pendapatan Mingguan
$startOfWeek = date("Y-m-d", strtotime("last sunday"));
$pendapatanMingguan = getPendapatan($conn, $startOfWeek, $today);

// Pendapatan Bulanan
$startOfMonth = date("Y-m-01");
$pendapatanBulanan = getPendapatan($conn, $startOfMonth, $today);

// Pendapatan Tahunan
$startOfYear = date("Y-01-01");
$pendapatanTahunan = getPendapatan($conn, $startOfYear, $today);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendapatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .card-custom {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
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
        .nav-bar {
            background-color: #343a40;
            padding: 10px 20px;
            color: white;
        }
        .nav-bar h2 {
            margin: 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="nav-bar">
        <h2><i class="fas fa-chart-line"></i> Dashboard Pendapatan</h2>
    </div>

    <!-- Dashboard Container -->
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
</body>
</html>
