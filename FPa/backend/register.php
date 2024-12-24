<?php
require 'database/db.php';

if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $name = $_POST['name'];
    $nomor_hp = $_POST['nomor_hp'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Pastikan ini sesuai dengan name di form

    // Memeriksa apakah password dan konfirmasi password cocok
    if ($password !== $confirm_password) {
        echo "Password tidak sesuai dengan konfirmasi password.";
    } else {
        // Encrypt password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data user ke database
        $query = "INSERT INTO akun (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        if (mysqli_query($db_connect, $query)) {
            echo "Registrasi berhasil!";
        } else {
            echo "Terjadi kesalahan saat registrasi.";
        }
    }
}
?>