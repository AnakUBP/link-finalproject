<?php
include('fungsi/db.php');

// Query data mobil dengan kategori
$sql = "
    SELECT m.*, k.nama_kategori
    FROM mobil m
    INNER JOIN kategori_mobil k ON m.id_kategori = k.id_kategori
    ORDER BY k.nama_kategori, m.merek
";
$result = $conn->query($sql);
?>

<div class="container">
    <?php
    if ($result && $result->num_rows > 0):
        $current_category = null;
        while ($row = $result->fetch_assoc()):
            if ($current_category !== $row['nama_kategori']):
                if ($current_category !== null): ?>
                    </div> <!-- Tutup row sebelumnya -->
                <?php endif; ?>
                <h3 class="mt-5"><?= $row['nama_kategori']; ?></h3>
                <div class="row">
                <?php $current_category = $row['nama_kategori']; ?>
            <?php endif; ?>

            <!-- Card untuk setiap mobil -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <img src="<?= $row['mobil_foto']; ?>" class="card-img-top" alt="<?= $row['merek']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-car"></i> <?= $row['merek'] . ' ' . $row['model']; ?></h5>
                        <p class="card-text">
                            <strong>Plat Nomor:</strong> <?= $row['plat_nomor']; ?><br>
                            <strong>Tahun:</strong> <?= $row['tahun_produksi']; ?><br>
                            <strong>Warna:</strong> <?= $row['warna']; ?><br>
                            <strong>Harga Sewa:</strong> Rp <?= number_format($row['harga_sewa'], 2, ',', '.'); ?><br>
                            <strong>Status:</strong> <?= ucfirst($row['status']); ?>
                        </p>
                        <a href="#" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Lihat lebih lanjut</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div> <!-- Tutup row terakhir -->
    <?php else: ?>
        <p class="text-center">Tidak ada data mobil yang tersedia.</p>
    <?php endif; ?>
    
    <?php
    include ('includes/footer.php')
    ?>
</div>

