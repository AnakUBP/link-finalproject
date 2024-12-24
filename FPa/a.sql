CREATE TABLE `akun` (
  `id_akun` int(11) PRIMARY KEY NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum('pelanggan','supir','admin','staff','manager') DEFAULT 'pelanggan',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `terakhir_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `supir` (
  `id_supir` int(11) PRIMARY key NOT NULL,
  `id_akun` int(11) NOT NULL,
  `no_sim` varchar(20) NOT NULL,
  `status` enum('tersedia','tidak tersedia') DEFAULT 'tersedia',
  `rating` decimal(3,2) DEFAULT NULL,
  `jumlah_ulasan` int(11) DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL
  FOREIGN key (id_akun) REFERENCES akun(id_akun) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) PRIMARY key NOT NULL,
  `id_akun` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  FOREIGN key (id_akun) REFERENCES akun(id_akun) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `staf` (
  `id_staf` int(11) PRIMARY key NOT NULL,
  `id_akun` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `shift` enum('pagi','siang','malam') NOT NULL,
  `status` enum('hadir','absen') DEFAULT NULL
  FOREIGN key (id_akun) REFERENCES akun(id_akun) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mobil` (
  `id_mobil` int(11) PRIMARY key NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `tahun_produksi` year(4) NOT NULL,
  `warna` varchar(30) NOT NULL,
  `harga_sewa` decimal(10,2) NOT NULL,
  `status` enum('tersedia','disewa','servis') DEFAULT 'tersedia',
  `tanggal_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  FOREIGN key (id_kategori) REFERENCES kategori_mobil(id_kategori) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `kategori_mobil` (
  `id_kategori` int(11) PRIMARY key NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
  FOREIGN key (id_mobil) REFERENCES mobil(id_mobil) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rental_pemesanan` (
  `id_pemesanan` int(11) PRIMARY key NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `durasi` int(11) GENERATED ALWAYS AS (to_days(`tanggal_berakhir`) - to_days(`tanggal_mulai`)) STORED,
  `harga_total` decimal(12,2) NOT NULL,
  FOREIGN key (id_pelanggan) REFERENCES pelanggan(id_pelanggan) on DELETE CASCADE,
  FOREIGN key (id_mobil) REFERENCES mobil(id_mobil) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `list_pemesanan` (
  `id_list` int(11) PRIMARY key NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_supir` int(11) NOT NULL,
  `pembayaran` decimal(12,2) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('belum bayar','sudah bayar') DEFAULT 'belum bayar'
  FOREIGN key (id_pemesanan) REFERENCES rental_pemesanan(id_pemesanan) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `akun` (`id_akun`, `nama_pengguna`, `email`, `kata_sandi`, `peran`, `tanggal_dibuat`, `terakhir_login`) VALUES
(1, '78987', 'faj@gmail.com', '$2y$10$I6CdDVy4AlFRJH0pK9zZg.oEZKNhkndatVoSvvx34eWVJ9Jj0EaWm', 'pelanggan', '2024-11-25 16:37:13', NULL);