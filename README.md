# PARFY.ID - Premium Perfume Store E-Commerce Platform

*[Read in Bahasa Indonesia](#versi-indonesia)*

**PARFY.ID** is a modern, high-performance web-based e-commerce platform crafted specifically for premium perfume retailing. Built with **Native PHP (MVC / Express-Style Custom Routing)**, **MySQL**, **HTML5**, **Vanilla CSS3 / Bootstrap 5**, and **SweetAlert2**, PARFY.ID provides a seamless, luxurious shopping experience for customers and a comprehensive management portal for administrators.

---

## 🌟 Key Features

### 🛍️ Customer Experience (100% Guest Shopping)
- **100% Frictionless Guest Browsing & Shopping**: Customers can freely browse the catalog, view product details, add items to cart, checkout, and submit reviews without mandatory login popups.
- **Product Gallery Slider**: Multi-image viewer supporting up to 3 high-resolution bottle photos, notes, accords, stock indicator, and sales counter.
- **Live Search & Category Filtering**: Filter fragrances by aroma notes (*Woody, Sweet, Fresh, Promo*) or live search.
- **Interactive Shopping Cart & Checkout**: Real-time quantity adjustments, price calculations, saved shipping addresses, and order history.
- **Customer Reviews & Ratings**: Submit 1–5 star ratings and written reviews directly on product detail pages.

### 🛡️ Administrator Portal (`/admin`)
- **Isolated Admin Authentication**: Dedicated 2-panel split login portal for store administrators.
- **Interactive Sales Dashboard**: Real-time business performance summaries, total revenue metrics, order counts, and interactive sales charts.
- **Product & Inventory Control**: Add new perfume variants with multi-image uploads (WebP/JPEG/PNG/URL), adjust prices, descriptions, and update stock numbers.
- **Order & Shipping Management**: Track incoming customer transactions, update shipping statuses (*Pending, Processing, Shipped, Completed*), and inspect order receipts.
- **Customer Review Moderation**: Monitor customer feedback and ratings.
- **Business Analytics**: Best-seller fragrance breakdowns and monthly sales trends.

---

## 🛠️ Technology Stack
- **Backend & Routing**: Native PHP (Express-style pattern router in `index.php`), REST API (`/api/*`).
- **Database**: MySQL (`parfy_db`).
- **Frontend & UI**: HTML5, Vanilla CSS3, Bootstrap 5, FontAwesome 6, Bootstrap Icons.
- **Interactivity & Dialogs**: JavaScript (ES6+), SweetAlert2, Chart.js.
- **Environment Compatibility**: Fully compatible with both **Apache XAMPP** (`http://localhost/coding web IMK/parfy-php/`) and **PHP Built-in Server** (`http://localhost:8000/`).

---

## ⚙️ Installation & Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Attarreyzi/coding-web-IMK.git
   ```
2. **Setup Database**:
   - Create a MySQL database named `parfy_db`.
   - Import `database.sql` into `parfy_db`.
3. **Configure Database Connection**:
   - Connection settings are located in `config/database.php`.
4. **Run Local Server**:
   - **Option A (PHP Built-in Server)**:
     ```bash
     cd parfy-php
     php -S localhost:8000
     ```
     Access customer store at `http://localhost:8000/` and Admin Portal at `http://localhost:8000/admin`.
   - **Option B (XAMPP Apache)**:
     Place project inside `htdocs/` and access `http://localhost/coding%20web%20IMK/parfy-php/`.

---

## 🔑 Admin Credentials

- **Admin Portal URL**: `http://localhost:8000/admin`
- **Email**: `admin@parfy.id`
- **Password**: `admin123`

---

## 👨‍💻 Developer

Developed by **[Attarreyzi](https://github.com/Attarreyzi)** as a full-stack web development implementation project.

---

<h1 id="versi-indonesia">PARFY.ID - Platform E-Commerce Toko Parfum Premium (Versi Indonesia)</h1>

**PARFY.ID** adalah platform e-commerce toko online parfum premium yang dibangun menggunakan **Native PHP (Arsitektur Routing Kustom)**, **MySQL**, **HTML5**, **Vanilla CSS3 / Bootstrap 5**, dan **SweetAlert2**. PARFY.ID menghadirkan pengalaman berbelanja parfum yang mewah dan bebas hambatan bagi pembeli, serta portal manajemen toko yang lengkap bagi administrator.

---

## 🌟 Fitur Utama

### 🛍️ Pengalaman Pembeli (100% Guest Shopping)
- **100% Bebas Belanja Tanpa Login**: Pembeli dapat bebas menjelajahi katalog, melihat detail produk, menambahkan barang ke keranjang, checkout pesanan, dan menulis ulasan tanpa terhalang pop-up login.
- **Galeri Foto Produk Slider**: Penampil multi-gambar yang mendukung hingga 3 foto botol parfum asli, deskripsi aroma, indikator stok, dan jumlah produk terjual.
- **Pencarian Live & Filter Kategori**: Memfilter parfum berdasarkan kategori aroma (*Woody, Sweet, Fresh, Promo*) maupun kata kunci pencarian.
- **Keranjang Belanja & Checkout Interaktif**: Pembaruan jumlah barang secara real-time, perhitungan total harga, manajemen alamat pengiriman, dan riwayat pesanan.
- **Ulasan & Rating Pembeli**: Fitur pemberian bintang 1–5 dan komentar ulasan yang langsung tampil di halaman detail produk.

### 🛡️ Portal Administrator (`/admin`)
- **Portal Otentikasi Admin Terisolasi**: Tampilan login 2-panel terpisah khusus untuk administrator toko.
- **Dashboard Performa Toko**: Ringkasan omzet penjualan, total pesanan, total produk, dan grafik statistik penjualan harian.
- **Kelola Produk & Inventaris Stok**: Menambah varian parfum baru lengkap dengan upload multi-foto, harga, deskripsi, serta pembaruan jumlah stok.
- **Kelola Transaksi & Pengiriman**: Memantau pesanan pembeli yang masuk, memperbarui status pengiriman pesanan (*Pending, Diproses, Dikirim, Selesai*), dan mencetak rincian transaksi.
- **Moderasi Ulasan Pembeli**: Memantau ulasan dan rating yang dikirim oleh pembeli.
- **Analisis Toko**: Grafik tren penjualan dan analisis parfum terlaris (*best seller*).

---

## 🛠️ Stack Teknologi
- **Backend & Routing**: Native PHP (Pola router Express di `index.php`), REST API (`/api/*`).
- **Basis Data**: MySQL (`parfy_db`).
- **Frontend & UI**: HTML5, Vanilla CSS3, Bootstrap 5, FontAwesome 6, Bootstrap Icons.
- **Interaktivitas**: JavaScript (ES6+), SweetAlert2, Chart.js.
- **Kompatibilitas Lingkungan**: Kompatibel penuh di **Apache XAMPP** (`http://localhost/coding web IMK/parfy-php/`) maupun **PHP Built-in Server** (`http://localhost:8000/`).

---

## ⚙️ Konfigurasi & Instalasi

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/Attarreyzi/coding-web-IMK.git
   ```
2. **Persiapan Basis Data**:
   - Buat basis data MySQL bernama `parfy_db`.
   - Import file `database.sql` ke dalam `parfy_db`.
3. **Konfigurasi Koneksi**:
   - Pengaturan koneksi dapat disesuaikan pada `config/database.php`.
4. **Jalankan Server Lokal**:
   - **Opsi A (PHP Built-in Server)**:
     ```bash
     cd parfy-php
     php -S localhost:8000
     ```
     Buka toko pembeli di `http://localhost:8000/` dan Portal Admin di `http://localhost:8000/admin`.
   - **Opsi B (Apache XAMPP)**:
     Letakkan folder proyek di `htdocs/` dan akses `http://localhost/coding%20web%20IMK/parfy-php/`.

---

## 🔑 Kredensial Login Admin

- **URL Portal Admin**: `http://localhost:8000/admin`
- **Email**: `admin@parfy.id`
- **Password**: `admin123`

---

## 👨‍💻 Developer / Pengembang

Dirancang dan dikembangkan secara penuh oleh **[Attarreyzi](https://github.com/Attarreyzi)** sebagai proyek implementasi pengembangan web *full-stack*.
