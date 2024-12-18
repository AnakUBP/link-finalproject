<?php
session_start();
include 'fungsi/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <?php
      if (!isset($_SESSION['id_akun'])) {
        include('includes/headera.php');
    } else {
        include('includes/header.php');
    }
    ?>
    <div class="container ">
        <h1 class="text-center">Booking Mobil</h1>
        <p class="text-center">Pilih mobil yang Anda inginkan dan lakukan pemesanan.</p>
        <?php include('includes/cardsection.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
