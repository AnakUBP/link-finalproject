<?php
require '../backend/manage.php';
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
      background-color: #eef2f7;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    h1{
        color:black
    }
    label {
        color:black
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
        <a class="nav-link" href="../view/data_kendaraan.php"><i class="fas fa-car fa-lg"></i> kendaraan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../.php"><i class="fas fa-user-circle"></i> manage akun</a>
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

    <div class="container mt-5">
        <h1 class="mb-4">Atur Jabatan Akun</h1>
        <form action="backend/manage.php" method="POST">
        <div class="form-group">
            <label for="user_id">Pilih Akun:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <?php
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['email'] . "</option>";
                }
                ?>
            </select>
        </div>
            <div class="form-group">
                <label for="role">Pilih Jabatan:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="supir">Supir</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; 2024 Buroq Transport. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>