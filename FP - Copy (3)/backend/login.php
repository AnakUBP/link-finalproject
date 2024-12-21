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
        if (password_verify($password, $akun['password'])) {
            $_SESSION['id'] = $akun['id'];
            $_SESSION['name'] = $akun['name'];
            $_SESSION['email'] = $akun['email'];
            $_SESSION['role'] = $akun['role'];

            // Redirect berdasarkan role user
            if ($akun['role'] == 'admin') {
                header('Location: ../admin/admin_dashboard.php');
            } else {
                header('Location: ../user/user_dashboard.php');
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
