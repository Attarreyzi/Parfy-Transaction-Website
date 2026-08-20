# PARFY.ID - Premium Perfume Store

PARFY.ID adalah aplikasi berbasis web yang dirancang khusus untuk toko online produk parfum premium dan pengelolaan transaksi jual beli. Aplikasi ini dibangun menggunakan Native PHP, basis data MySQL, HTML5, Vanilla CSS3 / Bootstrap 5, dan SweetAlert2.

Fokus utama dari sistem ini adalah untuk memfasilitasi transaksi jual beli parfum secara online dengan antarmuka yang responsif, fitur belanja 100% Guest Shopping tanpa hambatan login bagi pembeli, serta menyajikan dashboard admin terisolasi untuk mengelola produk, memantau pergerakan stok, dan menganalisis laporan transaksi harian secara terstruktur.

## Live Demo & Preview
Aplikasi dapat diakses secara langsung melalui tautan lokal berikut: [http://localhost:8000](http://localhost:8000)  
*(Portal Admin khusus Administrator di `/admin`)*

## Fitur Utama
- **Pengalaman Pembeli (100% Guest Shopping)**: Bebas menjelajah katalog, melihat detail produk, memilih varian aroma, menambah keranjang belanja, checkout, dan menulis ulasan tanpa harus login.
- **Katalog & Galeri Produk**: Penampil multi-gambar slider foto botol parfum asli (hingga 3 foto), deskripsi aroma, indikator stok real-time, dan harga rupiah.
- **Pencarian Live & Filter Kategori**: Pencarian cepat dan penyaringan produk berdasarkan kategori aroma (*Woody, Sweet, Fresh, Promo*).
- **Keranjang Belanja & Checkout Interaktif**: Manajemen kuantitas otomatis, kalkulasi total harga, alamat pengiriman, dan riwayat pesanan.
- **Ulasan & Rating Pembeli**: Sistem umpan balik bintang 1–5 dan komentar ulasan langsung di halaman produk.
- **Portal Administrator (`/admin`)**: Dashboard statistik bisnis, manajemen inventaris produk, pengelolaan stok, pemrosesan transaksi pengiriman (*Pending, Diproses, Dikirim, Selesai*), moderasi ulasan, dan analisis grafik penjualan.

## Stack Teknologi
**Backend & Database:**
- Native PHP (Express-style Router di `index.php`)
- REST API (`/api/*`)
- MySQL (`parfy_db`)

**Frontend & Interaksi:**
- HTML5 & Vanilla CSS3
- Bootstrap 5 & FontAwesome 6 / Bootstrap Icons
- JavaScript (ES6+), SweetAlert2, & Chart.js

## Instalasi Lokal
Untuk menjalankan proyek ini di perangkat lokal, ikuti langkah-langkah berikut:

1. Salin (clone) repositori ini: `git clone https://github.com/Attarreyzi/Parfy-Transaction-Website.git`
2. Pindahkan folder proyek ke dalam direktori web server (misalnya `htdocs` pada XAMPP).
3. Buat database baru di MySQL dengan nama `parfy_db`, lalu import file `database.sql`.
4. Sesuaikan pengaturan koneksi database pada file `config/database.php`.
5. Jalankan server lokal:
   - **Opsi A (PHP Built-in Server)**: Buka terminal di folder proyek lalu jalankan `php -S localhost:8000`. Akses `http://localhost:8000` di browser.
   - **Opsi B (Apache XAMPP)**: Akses `http://localhost/coding%20web%20IMK/parfy-php/` di browser.

## Hak Akses Admin
- **Portal Admin**: `http://localhost:8000/admin`
- **Email**: `admin@parfy.id`
- **Password**: `admin123`

## Developer / Pengembang
Dikembangkan oleh **[Attarreyzi](https://github.com/Attarreyzi)**
