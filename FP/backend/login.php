<?php
session_start();
require 'database/db.php'; // Pastikan ini menuju ke file koneksi database Anda

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan email
    $result = mysqli_query($db_connect, "SELECT * FROM akun WHERE email = '$email'");
    $akun = mysqli_fetch_assoc($result);

    if ($akun) {
        // Verifikasi password menggunakan password_verify jika password di hash
        if (password_verify($password, $akun['password'])) {
            // Set session variabel jika login berhasil
            $_SESSION['id'] = $akun['id'];
            $_SESSION['name'] = $akun['name'];
            $_SESSION['email'] = $akun['email'];
            $_SESSION['role'] = $akun['role'];

            // Redirect berdasarkan role user
            if ($akun['role'] == 'admin') {
                header('Location: ../admin/admin_dashboard.php'); // Jika admin, arahkan ke dashboard admin
            } else {
                header('Location: ../user/user_dashboard.php'); // Jika user biasa, arahkan ke profil
            }
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Email tidak ditemukan!";
    }
}
?>
