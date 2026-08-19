# PARFY.ID
*[Read in Bahasa Indonesia](#versi-indonesia)*

PARFY.ID is a web-based e-commerce application designed specifically for premium perfume stores. The application is built using native PHP, MySQL database, and third-party API integrations such as Midtrans for automated payments and BinderByte for regional data and logistics.

The primary focus of this system is to facilitate online perfume trading transactions with a responsive interface, provide interactive AI-based product recommendations, and present an admin dashboard to manage orders, monitor stock movements, and analyze daily sales reports in a structured manner.

## Key Features
- Product catalog with live search and filtering capabilities
- Product detail page supporting multi-image viewer (carousel slider)
- Shopping cart with automated total payment and shipping cost calculations
- Midtrans Payment Gateway integration for automated transaction processing
- AI-based Customer Service Assistant (Chatbot) for product recommendations
- User authentication system with interactive validation interface
- Admin dashboard for product management, stock control, and order processing
- Analytical reports and sales statistics charts

## Technology Stack
- **Programming Languages**: PHP, JavaScript
- **Markup & Styling**: HTML, CSS, Bootstrap
- **Database**: MySQL
- **System Integration**:
  - Midtrans API (Transaction Processing)
  - BinderByte API (Logistics and Region Management)
  - Perplexity API (AI Chatbot System)
  - PHPMailer (Email Notification Delivery)

## Configuration and Installation

The application can be run in a local environment using XAMPP or similar web servers that support PHP 8 and MySQL.

1. Clone the repository into the local server root directory (e.g., `htdocs`).
2. Create a new database in MySQL named `parfy_db`, then import the `database.sql` file to build the table structure.
3. Adjust the database connection parameters in the `config/database.php` file.
4. Adjust the Midtrans API Key configuration (Server Key and Client Key) in the `config/midtrans.php` file.
5. Adjust the BinderByte API Key configuration in the `config/binderbyte.php` file.
6. Open the project link via a browser to access the application.

## User Access

This system has two access levels. General users (buyers) can directly create an account through the **Register** page. However, to access the system management panel, you can use the following default credentials:

- **Admin**
  - Email: admin@parfy.id
  - Password: admin123

---

<h1 id="versi-indonesia">PARFY.ID (Versi Indonesia)</h1>

PARFY.ID adalah aplikasi e-commerce berbasis web yang dirancang khusus untuk toko parfum premium. Aplikasi ini dibangun menggunakan native PHP, basis data MySQL, dan integrasi API pihak ketiga seperti Midtrans untuk pembayaran dan BinderByte untuk data wilayah dan logistik otomatis.

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
  - API BinderByte (Manajemen Logistik dan Wilayah)
  - API Perplexity (Sistem Chatbot AI)
  - PHPMailer (Pengiriman Notifikasi Email)

## Konfigurasi dan Instalasi

Aplikasi ini dapat dijalankan di environment lokal menggunakan XAMPP atau web server sejenis yang mendukung PHP 8 dan MySQL.

1. Clone repositori ke dalam direktori root server lokal (misalnya `htdocs`).
2. Buat basis data baru di MySQL dengan nama `parfy_db`, kemudian import file `database.sql` untuk membuat struktur tabel.
3. Sesuaikan parameter koneksi basis data pada file `config/database.php`.
4. Sesuaikan konfigurasi API Key Midtrans (Server Key dan Client Key) pada file `config/midtrans.php`.
5. Sesuaikan konfigurasi API Key BinderByte pada file `config/binderbyte.php`.
6. Buka tautan proyek melalui browser untuk mengakses aplikasi.

## Akses Pengguna

Sistem ini memiliki dua tingkatan hak akses. Pengguna umum (pembeli) dapat langsung membuat akun melalui halaman Daftar/Register. Namun, untuk mengakses panel manajemen sistem, Anda dapat menggunakan kredensial bawaan berikut:

- **Admin**
  - Email: admin@parfy.id
  - Password: admin123

---

## Developer / Pengembang

Sistem ini dirancang dan dikembangkan secara penuh oleh **[Attarreyzi](https://github.com/Attarreyzi)** sebagai proyek implementasi pengembangan web *full-stack*. 

Anda dipersilakan untuk menggunakan kode sumber proyek ini sebagai referensi untuk keperluan akademik maupun pembelajaran mandiri.
