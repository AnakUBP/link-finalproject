<?php
// Koneksi ke database
include('fungsi/db.php');

// Mengecek apakah ada id yang diberikan
if (isset($_GET['id'])) {
    $id_pegawai = $_GET['id'];

    // Mengambil data pegawai berdasarkan id
    $sql = "SELECT * FROM pegawai WHERE id_pegawai = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pegawai);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $pegawai = $result->fetch_assoc();
        $jabatan = $pegawai['jabatan'];

        // Mengambil data tambahan sesuai jabatan
        if ($jabatan == 'admin') {
            $admin_sql = "SELECT * FROM admin WHERE id_pegawai = ?";
            $admin_stmt = $conn->prepare($admin_sql);
            $admin_stmt->bind_param("i", $id_pegawai);
            $admin_stmt->execute();
            $admin_result = $admin_stmt->get_result();
            $admin_data = $admin_result->fetch_assoc();
        } elseif ($jabatan == 'staf') {
            $staf_sql = "SELECT * FROM staf WHERE id_pegawai = ?";
            $staf_stmt = $conn->prepare($staf_sql);
            $staf_stmt->bind_param("i", $id_pegawai);
            $staf_stmt->execute();
            $staf_result = $staf_stmt->get_result();
            $staf_data = $staf_result->fetch_assoc();
        } elseif ($jabatan == 'supir') {
            $supir_sql = "SELECT * FROM supir WHERE id_pegawai = ?";
            $supir_stmt = $conn->prepare($supir_sql);
            $supir_stmt->bind_param("i", $id_pegawai);
            $supir_stmt->execute();
            $supir_result = $supir_stmt->get_result();
            $supir_data = $supir_result->fetch_assoc();
        }

        // Proses untuk menyimpan perubahan data jika form disubmit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_pegawai = $_POST['nama_pegawai'];
            $alamat = $_POST['alamat'];
            $no_telepon = $_POST['no_telepon'];
            $gaji = $_POST['gaji'];
            $foto = $_FILES['foto']['name'];

            // Jika ada foto yang diupload
            if ($foto) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($foto);
                move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            } else {
                // Jika tidak ada foto, gunakan foto yang sudah ada
                $target_file = $pegawai['foto'];
            }

            // Update data pegawai
            // Update data pegawai
            $update_sql = "UPDATE pegawai SET nama_pegawai = ?, alamat = ?, no_telepon = ?, gaji = ?, foto = ? WHERE id_pegawai = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sssisi", $nama_pegawai, $alamat, $no_telepon, $gaji, $target_file, $id_pegawai);

            if ($update_stmt->execute()) {
                // Update data di tabel jabatan sesuai dengan jabatan pegawai
                if ($jabatan == 'admin') {
                    $tipe_admin = $_POST['tipe_admin']; // Menangkap tipe admin dari form
                    $update_admin_sql = "UPDATE admin SET jabatan = ?, tipe_admin = ? WHERE id_pegawai = ?";
                    $update_admin_stmt = $conn->prepare($update_admin_sql);
                    $update_admin_stmt->bind_param("ssi", $jabatan, $tipe_admin, $id_pegawai);
                    $update_admin_stmt->execute();
                } elseif ($jabatan == 'staf') {
                    $update_staf_sql = "UPDATE staf SET jabatan = ? WHERE id_pegawai = ?";
                    $update_staf_stmt = $conn->prepare($update_staf_sql);
                    $update_staf_stmt->bind_param("si", $jabatan, $id_pegawai);
                    $update_staf_stmt->execute();
                } elseif ($jabatan == 'supir') {
                    $update_supir_sql = "UPDATE supir SET jabatan = ? WHERE id_pegawai = ?";
                    $update_supir_stmt = $conn->prepare($update_supir_sql);
                    $update_supir_stmt->bind_param("si", $jabatan, $id_pegawai);
                    $update_supir_stmt->execute();
                }

                echo "<script>alert('Data berhasil diperbarui!'); window.location.href='manage_workers.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat memperbarui data.');</script>";
            }
        }
    } else {
        die("Pegawai tidak ditemukan.");
    }
} else {
    die("ID Pegawai tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai</title>
    <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
    <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include('include/sidebar.php') ?>

    <div class="container mt-5">
        <h2 class="text-center" style="background-color:orange">Edit Pegawai</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" value="<?php echo $pegawai['nama_pegawai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $pegawai['alamat']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo $pegawai['no_telepon']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gaji" class="form-label">Gaji</label>
                <input type="number" class="form-control" id="gaji" name="gaji" value="<?php echo $pegawai['gaji']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <small>Foto saat ini: <img src="<?php echo $pegawai['foto']; ?>" alt="Foto Pegawai" width="100"></small>
            </div>

            <!-- Menampilkan inputan spesifik berdasarkan jabatan -->
            <?php if ($jabatan == 'admin') { ?>
                <div class="mb-3">
                    <label for="jabatan_admin" class="form-label">Jabatan Admin</label>
                    <input type="text" class="form-control" id="jabatan_admin" name="jabatan_admin" value="<?php echo $admin_data['jabatan']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tipe_admin" class="form-label">Tipe Admin</label>
                    <select class="form-control" id="tipe_admin" name="tipe_admin" required>
                        <option value="admin" <?php echo $admin_data['tipe_admin'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="super_admin" <?php echo $admin_data['tipe_admin'] == 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
                    </select>
                </div>
            <?php } elseif ($jabatan == 'staf') { ?>
                <div class="mb-3">
                    <label for="shift" class="form-label">Shift Staf</label>
                    <select class="form-control" id="shift" name="shift">
                        <option value="pagi" <?php echo ($staf_data['shift'] == 'pagi' ? 'selected' : ''); ?>>Pagi</option>
                        <option value="siang" <?php echo ($staf_data['shift'] == 'siang' ? 'selected' : ''); ?>>Siang</option>
                        <option value="malam" <?php echo ($staf_data['shift'] == 'malam' ? 'selected' : ''); ?>>Malam</option>
                    </select>
                </div>
            <?php } elseif ($jabatan == 'supir') { ?>
                <div class="mb-3">
                    <label for="no_sim" class="form-label">No. SIM</label>
                    <input type="text" class="form-control" id="no_sim" name="no_sim" value="<?php echo $supir_data['no_sim']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="tersedia" <?php echo ($supir_data['status'] == 'tersedia' ? 'selected' : ''); ?>>Tersedia</option>
                        <option value="tidak tersedia" <?php echo ($supir_data['status'] == 'tidak tersedia' ? 'selected' : ''); ?>>Tidak Tersedia</option>
                    </select>
                </div>
            <?php } ?>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

</body>

</html>