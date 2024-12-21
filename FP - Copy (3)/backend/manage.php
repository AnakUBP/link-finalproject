<?php

require '../database/db.php';

$sql = "SELECT id, email FROM akun";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    if (empty($user_id) || empty($role)) {
        echo "Data tidak lengkap!";
        exit;
    }

    $query = "UPDATE akun SET role = ? WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $role, $user_id);
        if ($stmt->execute()) {

            // Jika sukses, arahkan ke halaman lain atau beri pesan sukses
            echo "Role berhasil diperbarui!";
            header("Location: manage.php");
        } else {
            echo "Terjadi kesalahan saat memperbarui role.";
        }
        $stmt->close();
    } else {
        echo "Terjadi kesalahan dalam persiapan query.";
    }

    $conn->close();
} else {
    echo "Method tidak valid!";
}
?>
