
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="create.php">Lihat Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="show.php">Lihat Data Produk</a>
                    <li class="nav-item">
                        <a class="nav-link" href="backend/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Card untuk menampilkan informasi -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Selamat datang, Admin <?= htmlspecialchars($_SESSION['name']); ?>!</h2>
            </div>
            <div class="card-body">
                <p class="lead">Anda memiliki kontrol penuh atas produk dan pengguna. Silakan pilih salah satu opsi di bawah ini:</p>
                <div class="d-flex justify-content-between">
                    <!-- Tombol Lihat Produk -->
                    <a href="create.php" class="btn btn-primary btn-lg w-48">Lihat Produk</a>
                    <!-- Tombol Logout -->
                    <a href="backend/logout.php" class="btn btn-danger btn-lg w-48">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Link JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
