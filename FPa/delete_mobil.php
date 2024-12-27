<?php
require_once 'fungsi/db.php';

if (!isset($_GET['id_mobil'])) {
    die('ID Mobil tidak ditemukan.');
}

$id_mobil = intval($_GET['id_mobil']);

// Ambil status mobil saat ini
$sql_status = "SELECT status FROM mobil WHERE id_mobil = ?";
$stmt_status = $conn->prepare($sql_status);
$stmt_status->bind_param('i', $id_mobil);
$stmt_status->execute();
$result_status = $stmt_status->get_result();
$mobil = $result_status->fetch_assoc();

if (!$mobil) {
    die("Mobil tidak ditemukan.");
}

if ($mobil['status'] === 'berakhir') {
    // Jika status sudah "berakhir", hapus mobil dari database
    $sql_delete = "DELETE FROM mobil WHERE id_mobil = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param('i', $id_mobil);

    if ($stmt_delete->execute()) {
        header('Location: rental_cars.php');
        exit;
    } else {
        echo "Gagal menghapus mobil.";
    }
} else {
    // Jika status belum "berakhir", ubah status menjadi "berakhir"
    $sql_update = "UPDATE mobil SET status = 'berakhir' WHERE id_mobil = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('i', $id_mobil);

    if ($stmt_update->execute()) {
        header('Location: rental_cars.php');
        exit;
    } else {
        echo "Gagal memperbarui status mobil.";
    }
}
?>
