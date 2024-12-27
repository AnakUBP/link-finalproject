<?php
session_start();
require 'fungsi/db.php'; // File konfigurasi koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun']) || !isset($_SESSION['peran'])) {
    header('Location: login.php');
    exit();
}

// Periksa apakah pengguna memiliki hak akses
$peran = $_SESSION['peran'];
if ($peran !== 'admin' && $peran !== 'super admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin dan super admin.'); window.location = 'login.php';</script>";
    exit();
}

// Proses untuk membuat Admin, Staf, dan Supir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pegawai = $_POST['nama_pegawai'];
    $jabatan = $_POST['jabatan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $gaji = $_POST['gaji'];
    $foto = $_FILES['foto']['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $peran_akun = ($jabatan == 'admin' || $jabatan == 'super admin') ? $jabatan : 'pelanggan';

    // Proses upload foto
    if (!empty($foto)) {
        $foto_path = "../img/pegawai/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);
    } else {
        $foto_path = NULL;
    }

    // Menyimpan data pegawai
    $sql_pegawai = "
    INSERT INTO pegawai (nama_pegawai, jabatan, alamat, no_telepon, tanggal_bergabung, gaji, foto)
    VALUES (?, ?, ?, ?, NOW(), ?, ?)
    ";
    $stmt = $conn->prepare($sql_pegawai);
    $stmt->bind_param("ssssds", $nama_pegawai, $jabatan, $alamat, $no_telepon, $gaji, $foto_path);
    $stmt->execute();
    $id_pegawai = $stmt->insert_id; // Mendapatkan ID pegawai yang baru saja dimasukkan

    // Menyimpan data akun
    if ($jabatan == 'admin' || $jabatan == 'super admin') {
        $sql_akun = "
        INSERT INTO akun (nama_pengguna, email, kata_sandi, peran)
        VALUES (?, ?, ?, ?)
        ";
        $stmt_akun = $conn->prepare($sql_akun);
        $stmt_akun->bind_param("ssss", $username, $email, $password, $peran_akun);
        $stmt_akun->execute();
        $id_akun = $stmt_akun->insert_id; // Mendapatkan ID akun yang baru saja dimasukkan

        // Mengaitkan akun dengan pegawai
        $sql_pegawai_akun = "
        UPDATE pegawai
        SET id_akun = ?
        WHERE id_pegawai = ?
        ";
        $stmt_pegawai_akun = $conn->prepare($sql_pegawai_akun);
        $stmt_pegawai_akun->bind_param("ii", $id_akun, $id_pegawai);
        $stmt_pegawai_akun->execute();
    }

    // Menyimpan data jabatan (Admin, Staf, atau Supir)
    if ($jabatan == 'admin' || $jabatan == 'super admin') {
        $tipe_admin = $_POST['tipe_admin'];
        $sql_admin = "
        INSERT INTO admin (id_pegawai, tipe_admin)
        VALUES (?, ?)
        ";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("is", $id_pegawai, $tipe_admin);
        $stmt_admin->execute();
    } elseif ($jabatan == 'supir') {
        $no_sim = $_POST['no_sim'];
        $status_supir = $_POST['status_supir'];
        $sql_supir = "
        INSERT INTO supir (id_supir, no_sim, status, rating, jumlah_ulasan)
        VALUES (?, ?, ?, 0.00, 0)
        ";
        $stmt_supir = $conn->prepare($sql_supir);
        $stmt_supir->bind_param("iss", $id_pegawai, $no_sim, $status_supir);
        $stmt_supir->execute();
    } elseif ($jabatan == 'staf') {
        $shift = $_POST['shift'];
        $sql_staf = "
        INSERT INTO staf (id_pegawai, shift)
        VALUES (?, ?)
        ";
        $stmt_staf = $conn->prepare($sql_staf);
        $stmt_staf->bind_param("is", $id_pegawai, $shift);
        $stmt_staf->execute();
    }

    echo "<script>alert('Data pegawai berhasil dibuat!'); window.location = 'manage_workers.php';</script>";
}

// Mengambil daftar pegawai dari database
$sql_pegawai = "SELECT * FROM pegawai";
$result = $conn->query($sql_pegawai);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Workers</title>
    <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
    <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Menyembunyikan semua form dan tabel pegawai pada awalnya */
        .content {
            display: none;
        }
    </style>
</head>

<body>
    <?php include('include/sidebar.php') ?>

    <div class="container mt-5">
        <h1 class="text-center">Manage Workers</h1>

        <!-- Pilihan tombol untuk menampilkan form atau tabel -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-primary" id="btnAdmin">Buat Admin</button>
            <button type="button" class="btn btn-primary" id="btnStaf">Buat Staf</button>
            <button type="button" class="btn btn-primary" id="btnSupir">Buat Supir</button>
            <button type="button" class="btn btn-primary" id="btnManagePegawai">Kelola Pegawai</button>
        </div>

        <!-- Form untuk membuat Admin -->
        <div id="formAdmin" class="content">
            <h3>Form Admin</h3>
            <form method="POST" enctype="multipart/form-data">
                <!-- Form Admin Fields -->
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                </div>
                <div class="mb-3">
                    <label for="gaji" class="form-label">Gaji</label>
                    <input type="number" class="form-control" id="gaji" name="gaji" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="mt-1">
                        <input type="file" id="foto" name="foto">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="tipe_admin" class="form-label">Tipe Admin</label>
                    <select class="form-select" id="tipe_admin" name="tipe_admin" required>
                        <option value="admin">Admin</option>
                        <option value="super admin">Super Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

        <!-- Form untuk membuat Staf -->
        <div id="formStaf" class="content">
            <h3>Form Staf</h3>
            <form method="POST" enctype="multipart/form-data">
                <!-- Form Staf Fields -->
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                </div>
                <div class="mb-3">
                    <label for="gaji" class="form-label">Gaji</label>
                    <input type="number" class="form-control" id="gaji" name="gaji" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="mt-1">
                        <input type="file" id="foto" name="foto">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="shift" class="form-label">Shift</label>
                    <input type="text" class="form-control" id="shift" name="shift" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

        <!-- Form untuk membuat Supir -->
        <div id="formSupir" class="content">
            <h3>Form Supir</h3>
            <form method="POST" enctype="multipart/form-data">
                <!-- Form Supir Fields -->
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                </div>
                <div class="mb-3">
                    <label for="gaji" class="form-label">Gaji</label>
                    <input type="number" class="form-control" id="gaji" name="gaji" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="mt-1">
                        <input type="file" id="foto" name="foto">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="no_sim" class="form-label">No SIM</label>
                    <input type="text" class="form-control" id="no_sim" name="no_sim" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

        <!-- Tabel Daftar Pegawai -->
        <div id="pegawaiTable" class="content">
            <h3 class="mt-5">Daftar Pegawai</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Foto</th>
                        <th>Gaji</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='color:black'>" . $no++ . "</td>";
                        echo "<td style='color:black'>" . $row['nama_pegawai'] . "</td>";
                        echo "<td style='color:black'>" . $row['jabatan'] . "</td>";
                        echo "<td style='color:black'><img src='" . $row['foto'] . "' alt='Foto' width='50'></td>";
                        echo "<td style='color:black'>" . $row['gaji'] . "</td>";
                        echo "<td><a href='edit_worker.php?id=" . $row['id_pegawai'] . "' class='btn btn-warning'>Edit</a> <a href='delete_worker.php?id=" . $row['id_pegawai'] . "' class='btn btn-danger'>Hapus</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        // Fungsi untuk menyembunyikan semua konten
        function hideAllContents() {
            var contents = document.querySelectorAll('.content');
            contents.forEach(function(content) {
                content.style.display = 'none';
            });
        }

        // Menampilkan form atau tabel sesuai tombol yang ditekan
        document.getElementById('btnAdmin').addEventListener('click', function() {
            hideAllContents();
            document.getElementById('formAdmin').style.display = 'block';
        });

        document.getElementById('btnStaf').addEventListener('click', function() {
            hideAllContents();
            document.getElementById('formStaf').style.display = 'block';
        });

        document.getElementById('btnSupir').addEventListener('click', function() {
            hideAllContents();
            document.getElementById('formSupir').style.display = 'block';
        });

        document.getElementById('btnManagePegawai').addEventListener('click', function() {
            hideAllContents();
            document.getElementById('pegawaiTable').style.display = 'block';
        });
    </script>

</body>

</html>