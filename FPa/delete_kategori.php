<?php
// Koneksi database
require_once 'fungsi/db.php';

// Ambil ID kategori dari URL
$id_kategori = $_GET['id_kategori'] ?? null;

if ($id_kategori) {
    // Set id_kategori pada mobil menjadi NULL sebelum menghapus kategori
    $update_query = "UPDATE mobil SET id_kategori = NULL WHERE id_kategori = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("i", $id_kategori);
    $stmt_update->execute();

    // Hapus kategori berdasarkan ID
    $delete_query = "DELETE FROM kategori_mobil WHERE id_kategori = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("i", $id_kategori);

    if ($stmt_delete->execute()) {
        // Redirect setelah kategori berhasil dihapus
        header("Location: rental_cars.php ?message=Kategori berhasil dihapus");
        exit;
    } else {
        echo "Gagal menghapus kategori.";
    }
} else {
    echo "ID kategori tidak ditemukan.";
}
