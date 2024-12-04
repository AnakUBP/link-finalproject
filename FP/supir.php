<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        form {
            margin-top: 20px;
        }

        form div {
            margin-bottom: 10px;
        }

        form label {
            display: inline-block;
            width: 150px;
        }

        form input,
        form select {
            padding: 5px;
            width: calc(100% - 160px);
        }

        form button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Data Supir</h1>

    <!-- Tabel Supir -->
    <table>
        <thead>
            <tr>
                <th>ID Supir</th>
                <th>ID Akun</th>
                <th>No SIM</th>
                <th>Status</th>
                <th>Rating</th>
                <th>Jumlah Ulasan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_supir']; ?></td>
                            <td><?= $row['id_akun']; ?></td>
                            <td><?= $row['no_sim']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['rating']; ?></td>
                            <td><?= $row['jumlah_ulasan']; ?></td>
                            <td><img src="<?= $row['foto']; ?>" alt="foto" width="100"></td>
                            <td>
                                <a href="edit_kendaraan.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_supir.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data supir ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data supir.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form Tambah Supir -->
    <h2>Tambah Data Supir</h2>
    <form action="tambah_supir.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="id_supir">ID Supir:</label>
            <input type="number" id="id_supir" name="id_supir" required>
        </div>
        <div>
            <label for="id_akun">ID Akun:</label>
            <input type="number" id="id_akun" name="id_akun" required>
        </div>
        <div>
            <label for="no_sim">No SIM:</label>
            <input type="text" id="no_sim" name="no_sim" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="tersedia">Tersedia</option>
                <option value="tidak tersedia">Tidak Tersedia</option>
            </select>
        </div>
        <div>
            <label for="rating">Rating:</label>
            <input type="number" step="0.01" id="rating" name="rating">
        </div>
        <div>
            <label for="jumlah_ulasan">Jumlah Ulasan:</label>
            <input type="number" id="jumlah_ulasan" name="jumlah_ulasan">
        </div>
        <div>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
        </div>
        <button type="submit">Tambah Supir</button>
    </form>
</body>

</html>