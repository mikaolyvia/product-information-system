# Product Information System

Sistem Manajemen Data Informasi Produk berbasis web menggunakan arsitektur modular tiga lapis (_Three-Layer Architecture_)[cite: 4, 7].

---

## Tujuan Proyek

- Mengimplementasikan arsitektur modular tiga lapis (_Separation of Concerns_) menggunakan PHP Native tanpa basis data eksternal[cite: 4, 5].
- Mengorganisasi data inventaris katalog barang secara terstruktur[cite: 4, 7].
- Mengotomatisasi kalkulasi total nilai aset finansial seluruh persediaan barang di gudang[cite: 4, 7].
- Memberikan sistem peringatan dini visual berbasis warna baris tabel saat persediaan mencapai batas stok kritis (< 3 unit)[cite: 4, 7].

---

## Fitur Utama

- **Kalkulasi Total Nilai Aset Gudang:** Mengakumulasikan nilai seluruh persediaan barang (Harga Satuan × Stok Fisik) secara otomatis pada kotak ringkasan atas[cite: 4, 7].
- **Tabel Inventaris Produk:** Menyajikan data katalog lengkap dengan ID, Nama Produk, Kategori, Harga Satuan, Stok Fisik, dan Deskripsi fungsi dari setiap produk[cite: 4, 6, 7].
- **Indikator Visual Stok Kritis (< 3 Unit):** Logika _conditional_ yang otomatis menandai latar belakang baris tabel dengan warna merah muda saat persediaan di bawah 3 unit[cite: 4, 7].

---

## Struktur Berkas

- **`products.php` (Data Layer):** Menyimpan data katalog komoditas menggunakan _multidimensional array_ asosiatif (ID, Nama Produk, Kategori, Harga, Stok, dan Deskripsi)[cite: 4, 5].
- **`functions.php` (Processing Layer):** Memproses logika bisnis secara terisolasi melalui fungsi `hitungTotalNilaiStok()`, `cekWarnaBarisStok()`, dan `formatRupiah()`[cite: 4, 5].
- **`index.php` (Presentation Layer):** Menggabungkan modul dengan `require_once`, menyajikan struktur antarmuka tabel HTML via perulangan `foreach`, dan memuat _styling_ tampilan[cite: 4, 5].

---

## Cara Penggunaan & Pengujian

### 1. Menjalankan di Server Lokal

1. Simpan folder proyek pada direktori server lokal:  
   `C:\xampp\htdocs\product-information-system\`[cite: 5]
2. Jalankan modul **Apache** pada aplikasi **XAMPP Control Panel**[cite: 5].
3. Buka peramban (_web browser_) dan akses URL:  
   `http://localhost/product-information-system/`[cite: 5]

### 2. Membaca Informasi Antarmuka

- Kotak ringkasan di bagian atas menyajikan akumulasi total nilai finansial seluruh stok barang di gudang[cite: 7].
- Baris tabel dengan stok 0, 1, atau 2 otomatis disorot dengan warna merah muda sebagai penanda prioritas pengadaan kembali barang[cite: 4, 7].

### 3. Simulasi Pengujian Data

1. Buka berkas `products.php` di VS Code[cite: 5].
2. Ubah salah satu nilai stok yang awalnya berada di bawah 3 (misalnya `ELC-005` yang bernilai `0` diubah menjadi `7`)[cite: 5].
3. Simpan perubahan (`Ctrl + S`), lalu muat ulang peramban browser (`Ctrl + F5`)[cite: 5].
4. Baris tersebut otomatis kembali ke warna normal, dan nominal **Total Nilai Aset Gudang** di atas akan terkalkulasi naik secara otomatis[cite: 5].
