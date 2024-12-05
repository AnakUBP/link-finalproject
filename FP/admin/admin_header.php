<?php
// require_once '../fungsi/db.php';

// // Ambil data pengguna dari sesi jika tersedia
// $user = null;
// $unread_count = 0;
// $notifications = [];

// // Pastikan admin yang mengakses
// if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
//   // Ambil detail admin
//   $stmt = $pdo->prepare("SELECT foto, nama_lengkap, nomor_hp, email, username, role FROM users WHERE user_id = ?");
//   $stmt->execute([$_SESSION['user_id']]);
//   $user = $stmt->fetch();

//   // Hitung notifikasi dengan status 'unread' berdasarkan notification_id
//   $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE status = 'unread'");
//   $stmt->execute();
//   $unread_count = $stmt->fetchColumn();

//   // Ambil semua notifikasi
//   $stmt = $pdo->prepare("SELECT notification_id, message, type, status, created_at FROM notifications ORDER BY created_at DESC");
//   $stmt->execute();
//   $notifications = $stmt->fetchAll();
//}
?>

<!-- Custom CSS -->
<style>
.carousel-caption h5 {
  background-color: rgba(255, 255, 255, 0.7);
  border-radius: 20px;
  padding: 10px 20px;
  display: inline-block;
}

h5 {
  color: black;
}

/* Gaya untuk foto pengguna */
.user-photo {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 10px;
  cursor: pointer;
}

.navbar .user-info {
  display: flex;
  align-items: center;
}

/* Sidebar Styles */
.sidebar {
  width: 200px;
  background-color: #343a40;
  color: #fff;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  padding-top: 80px;
  z-index: 1000;
}

.sidebar img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
}

.sidebar h5,
.sidebar p {
  margin: 0px 0;
}

/* Content Styles */
.content {
  margin-left: 200px;
  padding: 40px 10px 10px;
}

/* Responsive Styles */
@media (max-width: 992px) {
  .sidebar {
    display: none;
  }

  .content {
    margin-left: 0;
    padding-top: 20px;
  }
}
</style>

<body>

  <!-- Sidebar -->
  <div class="sidebar bg-dark">
    <div class="container text-center text-light">
      <?php if ($user): ?>
      <img src="../uploads/<?= htmlspecialchars($user['foto']); ?>" alt="Foto Profil">
      <p><?= htmlspecialchars($user['nama_lengkap']); ?></p>
      <p><?= htmlspecialchars($user['nomor_hp']); ?></p>
      <p><?= htmlspecialchars($user['email']); ?></p>
      <a href="../admin/admin_dashboard.php" class="btn btn-secondary mt-1 col-md-12"><i class="fas fa-house"></i>
        Home</a>
      <a href="../list/list_user.php" class="btn alert-info mt-1 col-md-12"><i class="fas fa-users"></i> List Users</a>
      <a href="../list/list_studio.php" class="btn btn-success mt-1 col-md-12"><i class="fas fa-music"></i>
        Studio</a>
      <a href="../list/list_reservasi.php" class="btn btn-warning mt-1 col-md-12"><i class="fas fa-book"></i>
        Reservasi</a>
      <a href="../list/list_payments.php" class="btn btn-info mt-1 col-md-12"><i class="fa-solid fa-money-bills"></i>
        Pembayaran</a>
      <a href="../view/view_penghasilan.php" class="btn btn-secondary mt-1 col-md-12"><i class="fas fa-dollar"></i>
        Penghasilan</a>
      <a href="../logout.php" class="btn btn-danger mt-1 col-md-12"><i class="fas fa-sign-out-alt"></i> Logout</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#"><i class="fa-solid fa-music"></i> Studio Reservation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <span class="navbar-text text-white mr-2" id="currentDateTime"></span>
        </li>
        <li class="nav-item dropdown d-lg-none">
          <!-- d-lg-none: Hanya muncul di layar kecil -->
          <a class="nav-link dropdown-toggle text-white" href="#" id="sidebarDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-list"></i> Menu
          </a>
          <div class="dropdown-menu dropdown-menu-right alert-secondary" aria-labelledby="sidebarDropdown">
            <?php if ($user): ?>
            <a class="dropdown-item" href="../admin/admin_dashboard.php"><i class="fas fa-house"></i> Home</a>
            <a class="dropdown-item" href="../list/list_user.php"><i class="fas fa-users"></i> List Users</a>
            <a class="dropdown-item" href="../list/list_studio.php"><i class="fas fa-music"></i> Studio</a>
            <a class="dropdown-item" href="../list/list_reservasi.php"><i class="fas fa-book"></i> Reservasi</a>
            <a class="dropdown-item" href="../list/list_payment.php"><i class="fa-solid fa-money-bills"></i>
              Pembayaran</a>
            <a class="dropdown-item" href="../list/list_penghasilan.php"><i class="fas fa-dollar"></i> Penghasilan</a>
            <a class="dropdown-item text-danger" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php endif; ?>
          </div>
        </li>
        <li class="nav-item d-none d-lg-flex">
          <!-- d-none d-lg-flex: Hanya muncul di layar besar -->
          <?php if ($user): ?>
          <div class="dropdown">
            <img src="../uploads/<?= htmlspecialchars($user['foto']); ?>"
              alt="<?= htmlspecialchars($user['nama_lengkap']); ?>" class="user-photo" data-toggle="dropdown">
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">Profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../logout.php">Logout</a>
            </div>
          </div>
          <?php endif; ?>
        </li>
        <!-- Menampilkan badge notifikasi -->
        <li class="nav-item">
          <a class="nav-link text-white" href="../view/view_notifikasi.php">
            <i class="fas fa-bell"></i>
            <span id="notificationBadge" class="badge badge-danger"><?= $unread_count ?: ''; ?></span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Sidebar (untuk layar besar saja) -->
  <div class="sidebar bg-dark d-none d-lg-block">
    <div class="container text-center text-light">
      <?php if ($user): ?>
      <img src="../uploads/<?= htmlspecialchars($user['foto']); ?>" alt="Foto Profil">
      <p><?= htmlspecialchars($user['nama_lengkap']); ?></p>
      <p><?= htmlspecialchars($user['nomor_hp']); ?></p>
      <p><?= htmlspecialchars($user['email']); ?></p>
      <a href="../admin/admin_dashboard.php" class="btn btn-primary mt-1 col-md-12 text-left"><i
          class="fas fa-house"></i>
        Home</a>
      <a href="../list/list_user.php" class="btn btn-info mt-1 col-md-12 text-left"><i class="fas fa-users"></i> List
        Users</a>
      <a href="../list/list_studio.php" class="btn btn-success mt-1 col-md-12 text-left"><i class="fas fa-music"></i>
        Studio</a>
      <a href="../list/list_reservasi.php" class="btn btn-warning mt-1 col-md-12 text-left"><i class="fas fa-book"></i>
        Reservasi</a>
      <a href="../list/list_payment.php" class="btn btn-info mt-1 col-md-12 text-left"><i
          class="fa-solid fa-money-bills"></i>
        Pembayaran</a>
      <a href="../list/list_penghasilan.php" class="btn btn-secondary mt-1 col-md-12 text-left"><i
          class="fas fa-dollar"></i>
        Penghasilan</a>
      <a href="../logout.php" class="btn btn-danger mt-1 col-md-12 text-left"><i
          class="fas fa-sign-out-alt"></i>Logout</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Profile Modal -->
  <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="profileContent">
          <!-- Konten dari admin_profile.php akan dimuat di sini -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>