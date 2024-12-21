// Proses form jika data dikirim
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Supir</title>
</head>
<body>
    <h1>Berikan Rating untuk Supir</h1>
    <form action="" method="POST">
        <div>
            <label for="id_supir">ID Supir:</label>
            <input type="number" id="id_supir" name="id_supir" required>
        </div>
        <div>
            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" step="0.1" required>
        </div>
        <button type="submit">Kirim Rating</button>
    </form>

    <h2>Daftar Supir</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID Supir</th>
                <th>Nama</th>
                <th>Rating</th>
                <th>Jumlah Ulasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id_supir, nama, rating, jumlah_ulasan FROM supir";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id_supir']}</td>";
                    echo "<td>{$row['nama']}</td>";
                    echo "<td>{$row['rating']}</td>";
                    echo "<td>{$row['jumlah_ulasan']}</td>";
                    echo "<td><form method='POST' action=''>";
                    echo "<input type='hidden' name='id_supir' value='{$row['id_supir']}'>";
                    echo "<input type='number' name='rating' min='1' max='5' step='0.1' required placeholder='Beri Rating'>";
                    echo "<button type='submit'>Beri Rating</button>";
                    echo "</form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data supir.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>