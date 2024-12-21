<?php
// require '../database/db.php';

// $error = '';
// $success = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];
//     $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

//     // Update password di database.
//     $stmt = $conn->prepare("UPDATE akun SET kata_sandi = ? WHERE email = ?");
//     $stmt->bind_param('ss', $new_password, $email);

//     if ($stmt->execute()) {
//         $success = "Password berhasil diubah. Silakan login.";
//     } else {
//         $error = "Terjadi kesalahan. Silakan coba lagi.";
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
          background-color: #eef2f7;
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

        h2,label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #444;
        }

        .form-control{
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
        background-color: #4B569F!important;
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
  <a class="navbar-brand" href="index.php"><i class="fas fa-bus"></i> BUROQ TRANSPORT</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="services.php"><i class="fas fa-concierge-bell"></i> Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php"><i class="fas fa-user-circle"></i> Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container mb-3">
    <h2 class="text-center">Reset Password</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Masukkan Email Anda</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="new_password">Password Baru</label>
          
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
</body>
</html>
