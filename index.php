<?php
// index.php - Presentation Layer
require_once 'products.php';
require_once 'functions.php';

$totalAset = hitungTotalNilaiStok($products);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background-color: #f8fafc;
            color: #1e293b;
            padding: 2.5rem 1.5rem;
        }
        .wadah {
            max-width: 1050px;
            margin: 0 auto;
        }
        .header {
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.8rem;
        }
        .header h1 {
            font-size: 1.6rem;
            color: #0f172a;
        }
        .header p {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 0.3rem;
        }
        .kotak-nilai {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-left: 5px solid #2563eb;
            padding: 1.2rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        .kotak-nilai span {
            font-size: 0.85rem;
            color: #64748b;
            display: block;
        }
        .kotak-nilai strong {
            font-size: 1.5rem;
            color: #2563eb;
        }
        .wadah-tabel {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        th, td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        /* Penanda baris stok kritis (< 3) berupa warna merah muda tanpa teks */
        .baris-kritis {
            background-color: #fee2e2 !important;
        }
        .baris-kritis:hover {
            background-color: #fecaca !important;
        }
        .baris-normal:hover {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>

<div class="wadah">
    <div class="header">
        <h1>Product Information System</h1>
        <p>Sistem Manajemen Data Informasi Produk</p>
    </div>

    <!-- Kotak Ringkasan Total Nilai Aset Gudang -->
    <div class="kotak-nilai">
        <span>Total Nilai Aset Gudang:</span>
        <strong><?= formatRupiah($totalAset) ?></strong>
    </div>

    <!-- Tabel Data Produk -->
    <div class="wadah-tabel">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok Fisik</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $item): 
                    $kelasWarna = cekWarnaBarisStok($item['stok']);
                ?>
                <tr class="<?= $kelasWarna ?>">
                    <td><strong><?= $item['id'] ?></strong></td>
                    <td><strong><?= htmlspecialchars($item['nama']) ?></strong></td>
                    <td><?= $item['kategori'] ?></td>
                    <td><?= formatRupiah($item['harga']) ?></td>
                    <td><strong><?= $item['stok'] ?></strong></td>
                    <td><?= htmlspecialchars($item['deskripsi']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>