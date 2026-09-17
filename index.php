<?php
// index.php - Presentation Layer
require_once 'products.php';
require_once 'functions.php';

// Menangkap parameter GET untuk fitur pencarian dan filter
$keyword = $_GET['q'] ?? '';
$kategori = $_GET['cat'] ?? '';

// Eksekusi fungsi
$produkTerfilter = filterProduk($products, $keyword, $kategori);
$totalValuasi = hitungTotalNilaiStok($products);
$ringkasan = hitungRingkasanInventaris($products);
$topAsset = cariAsetTertinggi($products);
$daftarKategori = ambilDaftarKategori($products);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris & Valuasi Operasional - ElectroStore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <!-- Header -->
    <header class="header">
        <div>
            <h1>ElectroStore Ops Management</h1>
            <p>Sistem Pengendalian Stok & Monitoring Aset Gudang Elektronik</p>
        </div>
        <div>
            <span class="badge badge-success">Mode Operasional Aktif</span>
        </div>
    </header>

    <!-- KPI Summary Grid -->
    <section class="metrics-grid">
        <div class="metric-card blue">
            <span>Total Valuasi Aset Gudang</span>
            <h2><?= formatRupiah($totalValuasi) ?></h2>
        </div>
        <div class="metric-card emerald">
            <span>Total Kuantitas Fisik</span>
            <h2><?= $ringkasan['total_unit'] ?> <small style="font-size: 0.8rem;">Unit</small></h2>
        </div>
        <div class="metric-card amber">
            <span>Peringatan Stok Kritis (&lt;3)</span>
            <h2><?= $ringkasan['item_kritis'] ?> <small style="font-size: 0.8rem;">SKU</small></h2>
        </div>
        <div class="metric-card rose">
            <span>Stok Habis (Kehilangan Peluang)</span>
            <h2><?= $ringkasan['item_habis'] ?> <small style="font-size: 0.8rem;">SKU</small></h2>
        </div>
    </section>

    <!-- Filter & Search Bar -->
    <form method="GET" action="index.php" class="filter-bar">
        <input type="text" name="q" placeholder="Cari nama barang atau kode SKU..." value="<?= htmlspecialchars($keyword) ?>">
        
        <select name="cat">
            <option value="">Semua Kategori</option>
            <?php foreach ($daftarKategori as $kat): ?>
                <option value="<?= $kat ?>" <?= $kategori === $kat ? 'selected' : '' ?>><?= $kat ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn">Terapkan Filter</button>
        <?php if (!empty($keyword) || !empty($kategori)): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>

    <!-- Data Table Presentation -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>SKU ID</th>
                    <th>Nama Produk & Spesifikasi</th>
                    <th>Kategori</th>
                    <th>Harga Satuan</th>
                    <th>Stok Fisik</th>
                    <th>Valuasi Barang</th>
                    <th>Status Gudang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produkTerfilter)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                            Tidak ada produk yang cocok dengan kriteria pencarian.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produkTerfilter as $item): 
                        $status = cekStatusStok($item['stok']);
                        $nilaiTotalBarang = $item['harga'] * $item['stok'];
                    ?>
                    <tr>
                        <td><code><?= $item['id'] ?></code></td>
                        <td>
                            <strong><?= htmlspecialchars($item['nama']) ?></strong>
                            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">
                                <?= htmlspecialchars($item['deskripsi']) ?>
                            </div>
                        </td>
                        <td><span class="tag-category"><?= $item['kategori'] ?></span></td>
                        <td><?= formatRupiah($item['harga']) ?></td>
                        <td><strong><?= $item['stok'] ?></strong></td>
                        <td><?= formatRupiah($nilaiTotalBarang) ?></td>
                        <td>
                            <span class="badge <?= $status['badge_class'] ?>" title="<?= $status['pesan'] ?>">
                                <?= $status['label'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Analisis Eksekutif Mahasiswa SI -->
    <?php if ($topAsset): ?>
    <div class="highlight-box">
        <div>
            <strong>Insight Operasional:</strong> 
            Aset dengan penyerapan modal tertinggi saat ini adalah <strong><?= $topAsset['nama'] ?></strong> 
            sebesar <strong><?= formatRupiah($topAsset['valuasi']) ?></strong> (<?= $topAsset['stok'] ?> unit).
        </div>
        <span class="tag-category">Prioritas Pengamanan & Penjualan</span>
    </div>
    <?php endif; ?>

</div>

</body>
</html>