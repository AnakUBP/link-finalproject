<?php
require 'database/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $merk = $_POST['merk'];
    $tahun_produksi = $_POST['tahun produksi'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar'];

    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($gambar['name']);
    move_uploaded_file($gambar['tmp_name'], $upload_file);

    $conn = new mysqli('host', 'user', 'password', 'database');
    $sql = "INSERT INTO kendaraan (nama,merk,tahun produksi, kategori, deskripsi, gambar) VALUES ($nama,$merk,$tahun_produksi, $kategori, $deskripsi, $upload_file)";
    $conn->query($sql);
    echo "Kendaraan berhasil ditambahkan!";
}
?>