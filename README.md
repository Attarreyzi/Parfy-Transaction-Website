# PARFY.ID

PARFY.ID adalah aplikasi e-commerce berbasis web yang dirancang khusus untuk toko parfum premium. Aplikasi ini dibangun menggunakan native PHP, basis data MySQL, dan integrasi API pihak ketiga seperti Midtrans untuk pembayaran dan RajaOngkir untuk perhitungan biaya pengiriman otomatis.

Fokus utama dari sistem ini adalah untuk memfasilitasi transaksi jual beli parfum secara online dengan antarmuka yang responsif, menyediakan rekomendasi produk secara interaktif, serta menyajikan dashboard admin untuk mengelola pesanan, memantau pergerakan stok, dan menganalisis laporan penjualan harian secara terstruktur.

## Fitur Utama
- Katalog produk dengan pencarian dan penyaringan data secara live
- Halaman detail produk yang mendukung penampil multi-gambar (carousel slider)
- Keranjang belanja dengan perhitungan total pembayaran dan ongkos kirim otomatis
- Integrasi Midtrans Payment Gateway untuk pemrosesan transaksi otomatis
- Asisten Customer Service (Chatbot) berbasis AI untuk rekomendasi produk dan layanan pelanggan
- Sistem autentikasi pengguna dengan antarmuka validasi interaktif
- Dashboard admin untuk manajemen produk, pengelolaan stok, dan pemrosesan pesanan pembeli
- Laporan analitik dan grafik statistik penjualan

## Stack Teknologi
- **Bahasa Pemrograman**: PHP, JavaScript
- **Markup & Styling**: HTML, CSS, Bootstrap
- **Basis Data**: MySQL
- **Integrasi Sistem**:
  - API Midtrans (Pemrosesan Transaksi)
  - API RajaOngkir (Manajemen Logistik)
  - API Perplexity (Sistem Chatbot AI)
  - PHPMailer (Pengiriman Notifikasi Email)

## Konfigurasi dan Instalasi

Aplikasi ini dapat dijalankan di environment lokal menggunakan XAMPP atau web server sejenis yang mendukung PHP dan MySQL.

1. Clone repositori ke dalam direktori root server lokal (misalnya `htdocs`).
2. Buat basis data baru di MySQL dengan nama `parfy_db`, kemudian import file `database.sql` untuk membuat struktur tabel.
3. Sesuaikan parameter koneksi basis data pada file `config/database.php`.
4. Sesuaikan konfigurasi API Key Midtrans (Server Key dan Client Key) pada file `config/midtrans.php`.
5. Buka tautan proyek melalui browser untuk mengakses aplikasi.

## Akses Pengguna

Sistem ini memiliki dua tingkatan hak akses. Pembeli dapat langsung membuat akun melalui halaman **Daftar/Register**. Namun, untuk mengakses panel manajemen sistem, Anda dapat menggunakan kredensial bawaan berikut:

- **Admin**
  - Email: admin@parfy.id
  - Password: admin123

Dikembang oleh [Attarreyzi](https://github.com/Attarreyzi)
