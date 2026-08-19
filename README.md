# 🌸 PARFY.ID - Website E-Commerce Parfum Premium

<p align="center">
  <img src="assets/logo_parfum_bk.png" alt="PARFY.ID Logo" width="130">
</p>

<p align="center">
  <a href="https://github.com/Attarreyzi"><img src="https://img.shields.io/badge/Author-Attarreyzi-blue?style=for-the-badge&logo=github" alt="Author"></a>
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
</p>

---

## 📝 Tentang Website Ini

**PARFY.ID** adalah website e-commerce yang dibangun khusus untuk toko parfum online. Website ini dibuat dari nol (native) menggunakan PHP dan MySQL, dirancang biar pembeli gampang cari parfum sesuai aroma favorit mereka, dan proses checkout-nya otomatis terhubung ke sistem pembayaran (Midtrans) serta cek ongkir (RajaOngkir).

Proyek ini saya buat untuk mengimplementasikan sistem transaksi online yang *seamless* sekaligus fitur manajemen toko yang lengkap di sisi admin.

---

## ✨ Fitur Utama

### 🛒 Halaman Pembeli (Frontend)
- **Live Search & Filter Aroma**: Bisa cari parfum atau filter berdasarkan tipe aroma (Woody, Sweet, Fresh, dll) tanpa perlu loading ulang halaman.
- **Galeri Foto Parfum (Slider)**: Tiap produk bisa nampilin sampai 3 foto yang bisa digeser (slider/carousel).
- **Keranjang Belanja Real-Time**: Update jumlah barang dan hitung subtotal secara otomatis.
- **Cek Ongkir Otomatis**: Integrasi API RajaOngkir buat ngecek harga kurir JNE, POS, dan TIKI sesuai alamat pengiriman.
- **Pembayaran Otomatis (Midtrans)**: Udah terhubung ke Midtrans, jadi pembeli bisa bayar pakai QRIS, Virtual Account, atau e-Wallet dan sistem otomatis ngecek kalau udah lunas.
- **Fitur Review & Rating Bintang**: Pembeli yang udah selesai transaksi bisa ngasih ulasan dan rating ke produk.
- **Chatbot Customer Service Pintar**: Ada fitur live chat otomatis yang bisa ngasih rekomendasi parfum atau jawab pertanyaan soal cara order.
- **Keamanan Login (SweetAlert)**: User yang belum login nggak akan bisa checkout atau kasih review, bakal dicegat pakai pop-up cantik.

### ⚙️ Halaman Admin (Backend)
- **Kelola Produk & Foto**: Admin bisa tambah/edit produk, upload sampai 3 foto per parfum, dan ngatur deskripsi serta harganya.
- **Indikator Stok Cerdas**: Kalau stok mau habis (di bawah 10) warnanya kuning, kalau habis (0) warnanya merah. Gampang buat dipantau.
- **Manajemen Pesanan**: Fitur buat proses orderan masuk, update status ke "Dikirim", dan masukin nomor resi pengiriman.
- **Grafik Penjualan**: Dashboard analisis yang nampilin grafik omzet dan parfum mana aja yang paling laris.

---

## 🛠️ Teknologi yang Dipakai

- **Backend**: PHP 8 Native, REST API, JWT (JSON Web Tokens)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla), Bootstrap 5, SweetAlert2
- **Integrasi API Pihak Ketiga**:
  - **Midtrans Snap API**: Buat gateway pembayaran.
  - **RajaOngkir API**: Buat ngecek tarif ongkos kirim.
  - **PHPMailer**: Buat kirim email OTP pas lupa password.

---

## 📂 Struktur Folder

```text
parfy-php/
├── admin/                 # Halaman panel admin (Dashboard, Kelola Produk, Transaksi)
├── api/                   # Folder khusus endpoint API (JSON) buat frontend
├── assets/                # Gambar statis, logo, dan ikon
├── config/                # Konfigurasi database, Midtrans, dan JWT
├── forgot_password/       # Fitur reset password via email OTP
├── foto/                  # Tempat nyimpen hasil upload foto produk
├── js/                    # Script JavaScript utama
├── pages/                 # Halaman utama website buat pembeli (Katalog, Keranjang, dll)
├── database.sql           # File export database MySQL
└── index.php              # Router utama website
```

---

## 🚀 Cara Install di Komputer Lokal

Kalau mau jalanin website ini di laptop/komputer kamu (pake XAMPP):

1. **Clone repository ini** ke dalam folder `htdocs` XAMPP kamu:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/Attarreyzi/parfy-transaction-website.git "coding web IMK/parfy-php"
   ```
2. **Setup Database**:
   - Buka `http://localhost/phpmyadmin`
   - Bikin database baru dengan nama `parfy_db`
   - Import file `database.sql` ke dalam database tersebut.
3. **Cek Koneksi Database**:
   - Buka file `config/database.php` dan pastiin settingannya udah sesuai sama MySQL kamu (`root` dan password kosong).
4. **Jalankan Website**:
   - Tinggal buka browser dan ketik: `http://localhost/coding%20web%20IMK/parfy-php/`

*(Catatan: Jangan lupa isi `SERVER_KEY` Midtrans milik kamu sendiri di file `config/midtrans.php` biar fitur pembayarannya jalan).*

---

## 🔑 Akun Demo

Kalau mau coba login, bisa pakai akun bawaan ini:

| Role | Email | Password | Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@parfy.id` | `admin123` | `.../admin/dashboard.php` |
| **User Biasa** | `user@parfy.id` | `user123` | `.../dashboard` |

---

## 📄 Lisensi

Dibuat oleh **[Attarreyzi](https://github.com/Attarreyzi)** untuk keperluan portofolio dan pembelajaran.
Silakan dipelajari atau dimodifikasi!
