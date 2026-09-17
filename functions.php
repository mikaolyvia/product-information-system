<?php
// functions.php - Processing Layer

// Format rupiah standar Indonesia
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// 1. Ketentuan Wajib: Menghitung total nilai seluruh stok
function hitungTotalNilaiStok($daftarProduk) {
    $total = 0;
    foreach ($daftarProduk as $item) {
        $total += ($item['harga'] * $item['stok']);
    }
    return $total;
}

// 2. Ketentuan Wajib (Expanded): Status stok kritis (< 3)
function cekStatusStok($stok) {
    if ($stok == 0) {
        return [
            'label' => 'Habis',
            'badge_class' => 'badge-danger',
            'pesan' => 'Barang kosong, segera buat Purchase Order!'
        ];
    } elseif ($stok < 3) {
        return [
            'label' => 'Kritis (<3)',
            'badge_class' => 'badge-warning',
            'pesan' => 'Stok menipis, mendekati batas minimum.'
        ];
    } else {
        return [
            'label' => 'Aman',
            'badge_class' => 'badge-success',
            'pesan' => 'Persediaan mencukupi.'
        ];
    }
}

// 3. Nilai Tambah: Hitung ringkasan unit dan item kritis
function hitungRingkasanInventaris($daftarProduk) {
    $totalUnit = 0;
    $itemKritis = 0;
    $itemHabis = 0;

    foreach ($daftarProduk as $item) {
        $totalUnit += $item['stok'];
        if ($item['stok'] == 0) {
            $itemHabis++;
        } elseif ($item['stok'] < 3) {
            $itemKritis++;
        }
    }

    return [
        'total_sku' => count($daftarProduk),
        'total_unit' => $totalUnit,
        'item_kritis' => $itemKritis,
        'item_habis' => $itemHabis
    ];
}

// 4. Nilai Tambah: Cari produk dengan valuasi stok tertinggi (Capital Tied Up)
function cariAsetTertinggi($daftarProduk) {
    if (empty($daftarProduk)) return null;
    
    $tertinggi = null;
    $maxValuasi = -1;

    foreach ($daftarProduk as $item) {
        $valuasi = $item['harga'] * $item['stok'];
        if ($valuasi > $maxValuasi) {
            $maxValuasi = $valuasi;
            $tertinggi = $item;
            $tertinggi['valuasi'] = $valuasi;
        }
    }
    return $tertinggi;
}

// 5. Nilai Tambah: Filter data berdasarkan keyword dan kategori
function filterProduk($daftarProduk, $keyword = '', $kategori = '') {
    $hasil = [];
    $keyword = strtolower(trim($keyword));

    foreach ($daftarProduk as $item) {
        $cocokKeyword = empty($keyword) || 
            str_contains(strtolower($item['nama']), $keyword) || 
            str_contains(strtolower($item['id']), $keyword);
        
        $cocokKategori = empty($kategori) || ($item['kategori'] === $kategori);

        if ($cocokKeyword && $cocokKategori) {
            $hasil[] = $item;
        }
    }
    return $hasil;
}

// Ambil list kategori unik untuk opsi filter dropdown
function ambilDaftarKategori($daftarProduk) {
    $kategori = [];
    foreach ($daftarProduk as $item) {
        if (!in_array($item['kategori'], $kategori)) {
            $kategori[] = $item['kategori'];
        }
    }
    sort($kategori);
    return $kategori;
}