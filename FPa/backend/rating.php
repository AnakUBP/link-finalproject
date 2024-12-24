<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supir = $_POST['id_supir'];
    $rating = $_POST['rating'];

    // Ambil data supir saat ini
    $sql = "SELECT rating, jumlah_ulasan FROM supir WHERE id_supir = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_supir);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_rating = $row['rating'] ? $row['rating'] : 0;
        $current_reviews = $row['jumlah_ulasan'];

        // Hitung rating baru
        $new_reviews = $current_reviews + 1;
        $new_rating = (($current_rating * $current_reviews) + $rating) / $new_reviews;

        // Update data supir
        $update_sql = "UPDATE supir SET rating = ?, jumlah_ulasan = ? WHERE id_supir = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('dii', $new_rating, $new_reviews, $id_supir);

        if ($update_stmt->execute()) {
            echo "<script>alert('Rating berhasil ditambahkan!'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $update_stmt->error;
        }

        $update_stmt->close();
    } else {
        echo "<script>alert('Supir tidak ditemukan!'); window.location.href = 'index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>