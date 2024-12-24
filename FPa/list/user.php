<?php
// session_start();

// // Cek apakah user sudah login dan memiliki role admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

// include '../database/db.php';

// // Ambil parameter pencarian jika ada
// $search = isset($_GET['search']) ? $_GET['search'] : '';

// // Modifikasi query untuk menyertakan pencarian berdasarkan username atau email
// $query = $pdo->prepare("SELECT user_id, username, email, foto, nomor_hp, nama_lengkap, role, created_at FROM users WHERE username LIKE :search OR email LIKE :search");
// $query->bindValue(':search', "%$search%");
// $query->execute();
// $users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>

    <!-- Bootstrap -->
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/simplex/bootstrap.min.css"
        integrity="sha384-FYrl2Nk72fpV6+l3Bymt1zZhnQFK75ipDqPXK0sOR0f/zeOSZ45/tKlsKucQyjSp" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .content {
            margin-left: 220px;
            padding: 20px;
            margin-top: 50px;
        }

        .btn-action {
            width: 120px;
            /* You can adjust this value to your preference */
        }
    </style>
</head>

<body>
    <?php include '../admin/admin_header.php'; ?>
    <div class="content">
        <h2>Daftar Pengguna</h2>
        <hr class="bg-dark">

        <!-- Search Form -->
        <div class="mb-1">
            <form action="list_user.php" method="GET">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Username atau Email"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button onclick="window.history.back();" class="btn btn-info mt-1">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <a class="btn btn-danger mt-1" href="../admin/admin_dashboard.php"><i class="fa-solid fa-house"></i></a>
                <button type="submit" class="btn btn-primary mt-1"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <table class="table table-striped table-hover table-borderless text-center">
            <tr class="bg-dark text-light">
                <th>No</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <?php if (!empty($user['foto'])): ?>
                            <img src="../uploads/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Pengguna" width="50"
                                height="50">
                        <?php else: ?>
                            <p>Foto tidak tersedia</p>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <!-- Tombol View Profile yang akan memicu modal -->
                        <button class="btn btn-warning mt-1" data-toggle="modal"
                            data-target="#profileModal<?php echo $user['user_id']; ?>"><i class="fas fa-eye"></i></button>

                        <?php if ($user['user_id'] !== $_SESSION['user_id']): ?>
                            <!-- Tombol Edit (hanya muncul jika user_id berbeda dengan yang sedang login) -->
                            <a href="../list/list_reservasi.php?user_id=<?= $user['user_id'] ?>" class="btn btn-success mt-1"><i
                                    class="fas fa-list"></i></a>
                            <a class="btn btn-info mt-1" href="../update/update_user.php?id=<?php echo $user['user_id']; ?>"><i
                                    class="fas fa-edit"></i></a>
                            <!-- Tombol Delete -->
                            <a class="btn btn-primary mt-1" href="javascript:void(0);"
                                onclick="confirmDelete(<?php echo $user['user_id']; ?>)"><i class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Modal untuk setiap user -->
                <div class="modal fade" id="profileModal<?php echo $user['user_id']; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="profileModalLabel<?php echo $user['user_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="profileModalLabel<?php echo $user['user_id']; ?>">Profile:
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <img src="../uploads/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Pengguna"
                                        width="150" height="150">
                                </div>
                                <p><strong>Username:</strong><br> <?php echo htmlspecialchars($user['username']); ?></p>
                                <p><strong>Email:</strong><br> <?php echo htmlspecialchars($user['email']); ?></p>
                                <p><strong>Nomor HP:</strong><br> <?php echo htmlspecialchars($user['nomor_hp']); ?></p>
                                <p><strong>Nama Lengkap:</strong><br> <?php echo htmlspecialchars($user['nama_lengkap']); ?>
                                </p>
                                <p><strong>Role:</strong><br> <?php echo htmlspecialchars($user['role']); ?></p>
                                <p><strong>Created At:</strong><br> <?php echo htmlspecialchars($user['created_at']); ?></p>
                            </div>
                            <div class="modal-footer">
                                <a href="../update/update_user.php?id=<?php echo $user['user_id']; ?>"
                                    class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </table>
        <hr class="bg-dark">

        <script>
            function confirmDelete(userId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pengguna akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../delete/delete_user.php?id=" + userId;
                    }
                });
            }
        </script>
    </div>

    <?php include '../footer.php'; ?>

    <!-- Bootstrap JS, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>