<?php
// functions.php - Processing Layer

// Format angka ke format mata uang Rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// 1. Fungsi mengalkulasi total nilai aset gudang
function hitungTotalNilaiStok($daftarProduk) {
    $total = 0;
    foreach ($daftarProduk as $item) {
        $total += ($item['harga'] * $item['stok']);
    }
    return $total;
}

// 2. Logika conditional untuk menentukan kelas warna baris tabel
function cekWarnaBarisStok($stok) {
    if ($stok < 3) {
        // Baris tabel akan berwarna merah muda jika stok kritis (< 3)
        return "baris-kritis";
    }
    return "baris-normal";
}