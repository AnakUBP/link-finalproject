<?php
session_start();
require 'fungsi/db.php'; // File konfigurasi database

// Periksa apakah pengguna sudah login dan perannya super admin

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengguna = trim($_POST['nama_pengguna']);
    $email = trim($_POST['email']);
    $kata_sandi = password_hash(trim($_POST['kata_sandi']), PASSWORD_BCRYPT);
    $peran = trim($_POST['peran']); // admin atau super admin
    $gaji = floatval($_POST['gaji']);
    $nama_pegawai = trim($_POST['nama_pegawai']);
    $jabatan = 'admin'; // Semua admin memiliki jabatan 'admin'
    $alamat = trim($_POST['alamat']);
    $no_telepon = trim($_POST['no_telepon']);
    $tanggal_bergabung = date('Y-m-d');

    // Validasi input
    if (empty($nama_pengguna) || empty($email) || empty($_POST['kata_sandi']) || empty($gaji) || empty($nama_pegawai)) {
        $error = "Semua field wajib diisi!";
    } else {
        // Insert data ke tabel `pegawai`
        $stmt = $conn->prepare("INSERT INTO pegawai (nama_pegawai, jabatan, alamat, no_telepon, tanggal_bergabung, status) VALUES (?, ?, ?, ?, ?, 'aktif')");
        $stmt->bind_param("sssss", $nama_pegawai, $jabatan, $alamat, $no_telepon, $tanggal_bergabung);
        if ($stmt->execute()) {
            $id_pegawai = $conn->insert_id;

            // Insert data ke tabel `akun`
            $stmt = $conn->prepare("INSERT INTO akun (nama_pengguna, email, kata_sandi, peran) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama_pengguna, $email, $kata_sandi, $peran);
            if ($stmt->execute()) {
                $id_akun = $conn->insert_id;

                // Insert data ke tabel `admin`
                $stmt = $conn->prepare("INSERT INTO admin (id_akun, id_pegawai, gaji, tipe_admin) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iids", $id_akun, $id_pegawai, $gaji, $peran);
                if ($stmt->execute()) {
                    $success = "Akun admin berhasil didaftarkan!";
                } else {
                    $error = "Gagal menyimpan data admin.";
                }
            } else {
                $error = "Gagal menyimpan data akun.";
            }
        } else {
            $error = "Gagal menyimpan data pegawai.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
        integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Registrasi Admin</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_pengguna">Nama Pengguna</label>
                <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="kata_sandi">Kata Sandi</label>
                <input type="password" name="kata_sandi" id="kata_sandi" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="peran">Peran</label>
                <select name="peran" id="peran" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="super admin">Super Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="gaji">Gaji</label>
                <input type="number" name="gaji" id="gaji" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama_pegawai">Nama Pegawai</label>
                <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control">
            </div>
            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>
</body>

</html>