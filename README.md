# 🌸 PARFY.ID - Premium Fragrance E-Commerce Platform

<p align="center">
  <img src="assets/logo_parfum_bk.png" alt="PARFY.ID Logo" width="130">
  <br>
  <strong>Elevate Your Aura with Timeless Elegance</strong>
  <br>
  A modern, full-featured Fragrance E-Commerce Web Application built with PHP, MySQL, Vanilla JavaScript, Bootstrap 5, Midtrans Payment Gateway, Real-Time Shipping Calculations, Multi-Image Carousel, and an AI-Powered Customer Service Chatbot.
</p>

<p align="center">
  <a href="https://github.com/Attarreyzi"><img src="https://img.shields.io/badge/Author-Attarreyzi-blue?style=for-the-badge&logo=github" alt="Author"></a>
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/Midtrans-Payment_Gateway-002B49?style=for-the-badge&logo=buffer&logoColor=white" alt="Midtrans">
</p>

---

## 🌟 Overview

**PARFY.ID** is an end-to-end luxury perfume e-commerce web platform designed to deliver an engaging, elegant, and secure shopping experience. It bridges fragrance discovery and instant online purchasing with rich interactive features including aroma-based category exploration, multi-angle product sliders (up to 3 high-resolution photos per item), real-time live search, automated shipping cost calculations via major Indonesian couriers (JNE, POS, TIKI), automated payment settlement through Midtrans (QRIS, Virtual Accounts, E-Wallets), and a responsive AI Assistant Chatbot.

---

## 🚀 Key Features

### 🛍️ Customer Experience
- **Live Search & Dynamic Grid**: Instant in-place keyword filtering across names, brands, notes, and accords without page reloads.
- **Fragrance Exploration & Scent Profiles**: Browse curated scent categories (*Woody & Oud, Sweet & Gourmand, Fresh & Aquatic, Floral, Fruity*) and special discount offerings.
- **Interactive Multi-Photo Slider**:
  - Displays up to **3 high-resolution product photos** synced with the Admin management system.
  - Smooth left/right navigation arrows, photo position badges (`1 / 3`), interactive thumbnail gallery, and mobile touch-swipe gesture support.
- **Product Reviews & Star Ratings**: Verified buyers can submit star ratings and detailed reviews post-purchase.
- **Real-Time Shopping Cart & Address Book**:
  - Add to cart, adjust quantities dynamically, and select shipping destination addresses with live province/city data.
- **Automated Payment Gateway (Midtrans Integration)**:
  - Supports QRIS (GoPay, OVO, Dana, ShopeePay, BCA Mobile), Virtual Accounts (BCA, Mandiri, BNI, BRI, Permata), and Convenience Stores (Indomaret, Alfamart) with automatic status verification.
- **AI Customer Service Chatbot**:
  - Built-in intelligent hybrid chat engine that suggests fragrances based on specific user notes, occasion, longevity, budget, and explains store policies with clickable product links.
- **SweetAlert2 Authentication Security**:
  - Interactive modal dialogs safeguarding checkout, cart modifications, and reviews for unauthenticated visitors while allowing seamless catalog browsing.

### 🛡️ Admin Dashboard
- **Product Master Management**: Add, edit, and delete perfume entries with up to 3 image uploads/URLs, scent categories, sizes, prices, and stock counts.
- **Smart Color-Coded Inventory Control**:
  - Dynamic visual badges: **Yellow** for low stock (< 10 units) and **Red** for out-of-stock (0 units).
- **Order Processing & Tracking**: Real-time order monitoring (Pending, Paid, Shipped, Completed, Cancelled) with automated airway bill (resi) input.
- **Revenue Analytics & Visual Charts**: Revenue metrics, daily/monthly sales volume charts, top-selling fragrances, and customer retention stats.
- **Customer & Review Moderation**: User account management and review moderation tools.

---

## 🏗️ Architecture & Technology Stack

| Layer | Technologies |
| :--- | :--- |
| **Backend & API** | PHP 8.1+ Native, RESTful JSON Architecture, MVC routing, JWT Auth |
| **Database** | MySQL / MariaDB (InnoDB, UTF8mb4, `LONGTEXT` image arrays) |
| **Frontend UI/UX** | HTML5 Semantic, Modern Vanilla CSS3, Bootstrap 5.3, Bootstrap Icons, SweetAlert2 |
| **Payment Gateway** | Midtrans Snap API (Core API + Snap JS Webhook Integration) |
| **Shipping API** | RajaOngkir Integration (JNE, POS Indonesia, TIKI) |
| **Mailing / OTP** | PHPMailer (SMTP Email Verification & Password Recovery) |

---

## 📂 Project Structure

```text
parfy-php/
├── admin/                 # Admin Panel & Management Dashboards
│   ├── analysis.php       # Sales Analytics, Metrics & Charts
│   ├── dashboard.php      # Overview & Statistics Summary
│   ├── produk.php         # Master Product CRUD (3-Photo Uploads)
│   ├── review.php         # Customer Review Moderation
│   ├── stok.php           # Inventory & Stock Monitor (Color-coded)
│   ├── transaksi.php      # Order Processing & Tracking Management
│   └── user.php           # User & Account Management
├── api/                   # RESTful API Endpoints (JSON)
│   ├── auth/              # Authentication (Login, Register, Profile)
│   ├── cart/              # Shopping Cart CRUD Operations
│   ├── chat/              # AI Customer Service Engine
│   ├── payment/           # Midtrans Payment Notifications & Status
│   ├── products/          # Product Catalog & Detail APIs
│   ├── reviews/           # Product Reviews & Ratings
│   ├── shipping/          # Courier Cost Calculations
│   ├── transactions/      # Orders & Transaction Handling
│   └── users/             # Address Book & Profile Management
├── assets/                # Static Media, Logos, & Brand Graphics
├── config/                # System & Service Configurations
│   ├── database.php       # MySQL Database Connection
│   ├── jwt.php            # JWT Token Encoder/Decoder
│   └── midtrans.php       # Midtrans Payment Gateway API Keys
├── forgot_password/       # Password Reset & OTP Email Verification
├── foto/                  # Uploaded Product Media Storage
├── js/                    # Core Client API Helper (api.js)
├── pages/                 # Frontend Customer Views
│   ├── dashboard.php      # Authenticated Customer Dashboard
│   ├── logout.php         # Public Guest Landing Page
│   ├── detail-produk.php  # Product Detail & Multi-Image Slider
│   ├── hlmnkeranjang.php  # Cart & Checkout Experience
│   ├── hlmnPesanan.php    # Order History & Tracking
│   ├── hlmnAlamat.php     # Customer Address Book
│   ├── hlmnakun.php       # User Account & Profile Settings
│   ├── kategori.php       # Scent Notes & Special Promos Catalog
│   ├── login.php          # User Login Portal
│   └── regis.php          # Account Registration Portal
├── database.sql           # Complete Database Schema & Seed Data
├── index.php              # Central Request Router & Dispatcher
└── README.md              # Project Documentation
```

---

## 💻 Local Setup & Installation

### 1. Prerequisites
- **Web Server**: [XAMPP](https://www.apachefriends.org/) or Laragon with **PHP 8.0+** and **MySQL**.
- Enabled PHP Extensions: `curl`, `json`, `mysqli`, `openssl`, `mbstring`.
- **Git** installed on your system.

### 2. Clone the Repository
Clone the project into your web server directory (e.g., `htdocs` for XAMPP):
```bash
cd C:\xampp\htdocs
git clone https://github.com/Attarreyzi/parfy-php.git "coding web IMK/parfy-php"
```

### 3. Database Configuration
1. Start **Apache** and **MySQL** in XAMPP Control Panel.
2. Open **phpMyAdmin** at `http://localhost/phpmyadmin`.
3. Create a new database named: `parfy_db`.
4. Import the **`database.sql`** file located in the root of the project.

### 4. Configure Database Connection
Verify the settings in `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'parfy_db');
```

### 5. Launch the Application
Access the project via your browser:
```text
http://localhost/coding%20web%20IMK/parfy-php/
```

---

## 🔐 Demo Credentials

| Account Role | Email | Password | Access Dashboard |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@parfy.id` | `admin123` | [Admin Panel](http://localhost/coding%20web%20IMK/parfy-php/admin/dashboard.php) |
| **Customer User** | `user@parfy.id` | `user123` | [Customer Dashboard](http://localhost/coding%20web%20IMK/parfy-php/dashboard) |

---

## 📦 Pushing Changes to GitHub

To push the latest codebase to your GitHub repository:

```bash
# Add your GitHub repository as remote origin
git remote add origin https://github.com/Attarreyzi/parfy-php.git

# Set main/master branch and push
git branch -M master
git push -u origin master
```

---

## 📄 License & Attribution

Developed by **[Attarreyzi](https://github.com/Attarreyzi)**.  
This project is open-source and available under the **MIT License**.  
© 2026 **PARFY.ID**. All rights reserved.
