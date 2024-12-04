<?php
session_start();
require '../database/db.php'; // Pastikan ini menuju ke file koneksi database Anda

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan email
    $result = mysqli_query($db_connect, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Verifikasi password menggunakan password_verify jika password di hash
        if (password_verify($password, $user['password'])) {
            // Set session variabel jika login berhasil
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role user
            if ($user['role'] == 'admin') {
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
