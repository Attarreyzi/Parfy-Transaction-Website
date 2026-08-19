<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang & Checkout</title>
  <style>
    /* --- CSS GLOBAL --- */
    :root {
      --primary-bg: linear-gradient(180deg, #4b8bbf, #0d3256);
      --secondary-bg: #f4f4f4;
      --card-bg: #f1f1f1;
      --text-color: #0d3256;
      --muted-text: #777;
      --border-color: #ccc;
      --hover-bg: white;
      --btn-bg: #0d3256;
      --btn-text: white;
      --danger: #ff4d4d;
      --success: #28a745;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: var(--secondary-bg);
      color: var(--text-color);
    }

    .container {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 280px;
      background: var(--primary-bg);
      color: white;
      padding: 40px 30px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
      text-align: center;
      margin-bottom: 0px;
    }

    .logo img {
      width: 150px;
      margin-bottom: 8px;
      border-radius: 50%;
    }

    .logo h2 {
      margin: 0;
      font-size: 22px;
      letter-spacing: 1px;
    }

    .logo p {
      margin: 0;
      font-size: 12px;
      opacity: 0.9;
    }

    .menu {
      display: flex;
      flex-direction: column;
      gap: 30px;
      margin-top: 40px;
    }

    .menu-item {
      display: flex;
      align-items: center;
      font-size: 20px;
      cursor: pointer;
      padding: 10px;
      border-radius: 30px;
      transition: 0.3s;
      position: relative;
    }

    .menu-item:hover {
      background: var(--hover-bg);
      color: var(--text-color);
      transform: translateX(5px);
    }

    .menu-item.active {
      background: var(--hover-bg);
      color: var(--text-color);
      border-right: 4px solid white;
    }

    .menu-item svg {
      width: 26px;
      height: 26px;
      margin-right: 15px;
      fill: currentColor;
    }

    .menu-item a {
      text-decoration: none;
      color: inherit;
      display: flex;
      align-items: center;
      width: 100%;
    }

    /* Main Content */
    .main {
      flex: 1;
      background: var(--secondary-bg);
      padding: 40px 60px;
      position: relative;
      overflow-y: auto;
    }

    .profile-header {
      position: absolute;
      top: 30px;
      right: 40px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile-header .icon {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: #eaeaea;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
    }

    .content-card {
      background: var(--card-bg);
      padding: 40px 50px;
      border-radius: 25px;
      margin-top: 60px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      min-height: 400px;
    }

    h1 {
      margin-top: 0;
      margin-bottom: 30px;
      font-size: 28px;
      font-weight: 600;
    }

    .btn-back {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: var(--btn-text);
      background: var(--btn-bg);
      padding: 10px 18px;
      border-radius: 8px;
    }

    /* Cart Specifics */
    .cart-layout {
      display: flex;
      gap: 30px;
      align-items: flex-start;
    }

    .cart-items {
      flex: 2;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .cart-item {
      background: white;
      padding: 20px;
      border-radius: 15px;
      display: flex;
      align-items: center;
      gap: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .checkbox-wrapper input {
      width: 20px;
      height: 20px;
      cursor: pointer;
    }

    .item-img {
      width: 80px;
      height: 80px;
      border-radius: 10px;
      object-fit: cover;
      background: #ddd;
    }

    .item-details {
      flex: 1;
    }

    .item-details h4 {
      margin: 0 0 5px;
      font-size: 18px;
      color: var(--text-color);
    }

    .item-details .price {
      font-weight: bold;
      color: var(--btn-bg);
      font-size: 16px;
    }

    .item-details .variant {
      font-size: 13px;
      color: var(--muted-text);
      margin-bottom: 8px;
    }

    .qty-control {
      display: flex;
      align-items: center;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      overflow: hidden;
    }

    .qty-btn {
      background: #f8f9fa;
      border: none;
      width: 30px;
      height: 30px;
      cursor: pointer;
      font-weight: bold;
    }

    .qty-input {
      width: 40px;
      text-align: center;
      border: none;
      border-left: 1px solid var(--border-color);
      border-right: 1px solid var(--border-color);
      height: 30px;
      outline: none;
    }

    .btn-delete {
      background: none;
      border: none;
      color: var(--muted-text);
      cursor: pointer;
      font-size: 20px;
      transition: color 0.3s;
    }

    .btn-delete:hover {
      color: var(--danger);
    }

    /* Cart Summary */
    .cart-summary {
      flex: 1;
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 20px;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      font-size: 15px;
      color: var(--muted-text);
    }

    .summary-row.total {
      border-top: 1px dashed var(--border-color);
      padding-top: 15px;
      margin-top: 20px;
      color: var(--text-color);
      font-weight: bold;
      font-size: 18px;
    }

    .btn-checkout {
      width: 100%;
      background: var(--btn-bg);
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: opacity 0.3s;
      margin-top: 10px;
    }

    .btn-checkout:hover {
      opacity: 0.9;
    }

    /* --- CSS UNTUK OVERLAY CHECKOUT & POPUP --- */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(5px);
      display: none;
      /* Sembunyi default */
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    /* Box Checkout */
    .checkout-box {
      background: white;
      width: 600px;
      max-height: 90vh;
      overflow-y: auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: slideUp 0.3s ease-out;
    }

    .checkout-section {
      margin-bottom: 20px;
      border-bottom: 1px solid #eee;
      padding-bottom: 20px;
    }

    .checkout-section h3 {
      margin: 0 0 15px;
      color: var(--text-color);
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Address Preview */
    .addr-box {
      font-size: 14px;
      color: var(--muted-text);
      line-height: 1.5;
      background: #f9f9f9;
      padding: 15px;
      border-radius: 10px;
    }

    .addr-box strong {
      color: var(--text-color);
      display: block;
      margin-bottom: 5px;
      font-size: 15px;
    }

    /* Payment Cards */
    .payment-options {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .payment-card {
      border: 2px solid #ddd;
      padding: 15px;
      border-radius: 12px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 15px;
      transition: 0.2s;
      position: relative;
    }

    .payment-card:hover {
      background: #f0f8ff;
      border-color: #4b8bbf;
    }

    .payment-card.selected {
      background: #eef4f9;
      border-color: #0d3256;
    }

    .payment-card input {
      width: 18px;
      height: 18px;
      accent-color: #0d3256;
    }

    /* Close Button */
    .btn-close-modal {
      position: absolute;
      top: 20px;
      right: 20px;
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #777;
    }

    /* Success Popup */
    .success-box {
      background: white;
      width: 350px;
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .success-icon {
      font-size: 60px;
      color: var(--success);
      margin-bottom: 20px;
    }

    @keyframes slideUp {
      from {
        transform: translateY(50px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes popIn {
      from {
        transform: scale(0.5);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar {
        width: 250px;
        padding: 20px;
      }

      .main {
        padding: 20px;
      }

      .cart-layout {
        flex-direction: column;
      }

      .cart-summary {
        width: 100%;
        position: static;
      }
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
        min-height: 100vh;
      }

      /* Hide sidebar by default on mobile */
      .sidebar {
        position: fixed;
        left: -100%;
        top: 0;
        width: 280px;
        height: 100vh;
        z-index: 1000;
        transition: left 0.3s ease;
        overflow-y: auto;
      }

      .sidebar.active {
        left: 0;
      }

      /* Overlay when sidebar is open */
      .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
      }

      .sidebar-overlay.active {
        display: block;
      }

      /* Mobile Header */
      .mobile-header {
        display: flex !important;
        background: var(--primary-bg);
        color: white;
        padding: 15px 20px;
        align-items: center;
        gap: 15px;
        position: sticky;
        top: 0;
        z-index: 100;
      }

      .mobile-header .hamburger {
        font-size: 24px;
        cursor: pointer;
        background: none;
        border: none;
        color: white;
      }

      .mobile-header .page-title {
        font-size: 18px;
        font-weight: 600;
        flex: 1;
      }

      .mobile-header .mobile-icons {
        display: flex;
        gap: 15px;
      }

      .mobile-header .mobile-icons a {
        color: white;
        font-size: 20px;
      }

      .main {
        padding: 15px;
        margin-top: 0;
      }

      .content-card {
        margin-top: 10px;
        padding: 20px 15px;
        border-radius: 15px;
      }

      .content-card h1 {
        font-size: 22px;
        margin-bottom: 20px;
      }

      .profile-header {
        display: none !important;
      }

      .btn-back {
        display: none;
      }

      .checkout-box {
        width: 95%;
        padding: 20px;
      }

      .cart-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .cart-item .item-details {
        width: 100%;
      }

      .cart-summary {
        margin-top: 20px;
      }
    }

    /* Mobile header hidden by default */
    .mobile-header {
      display: none;
    }

    .sidebar-overlay {
      display: none;
    }

    /* Payment Overlay Styles */
    .payment-details-box {
      background: white;
      width: 450px;
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: slideUp 0.3s ease-out;
    }

    .qr-container {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 15px;
      margin: 20px 0;
    }

    .qr-container img {
      max-width: 200px;
      border-radius: 10px;
    }

    .va-container {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 15px;
      margin: 20px 0;
    }

    .va-number {
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 2px;
      color: var(--btn-bg);
      background: white;
      padding: 15px;
      border-radius: 10px;
      margin: 15px 0;
      border: 2px dashed var(--btn-bg);
    }

    .bank-select {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      margin-bottom: 15px;
      font-size: 15px;
    }

    .payment-timer {
      color: #dc3545;
      font-weight: bold;
      font-size: 18px;
      margin: 15px 0;
    }

    .btn-confirm-payment {
      width: 100%;
      background: var(--success);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 10px;
    }

    .btn-cancel-payment {
      width: 100%;
      background: transparent;
      color: var(--muted-text);
      padding: 10px;
      border: none;
      font-size: 14px;
      cursor: pointer;
      margin-top: 10px;
    }
  </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!-- Mobile Header -->
  <div class="mobile-header">
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
    <span class="page-title">Keranjang</span>
    <div class="mobile-icons">
      <a href="/coding web IMK/parfy-php/dashboard">🏠</a>
      <a href="/coding web IMK/parfy-php/pesanan">📦</a>
    </div>
  </div>

  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

  <div class="container">
    <div class="sidebar">
      <div class="logo">
        <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="Logo">
        <h2>PARFY.ID</h2>
        <p>TOKO PARFUM TERMURAH</p>
      </div>

      <div class="menu">
        <div class="menu-item"><a href="/coding web IMK/parfy-php/akun"><svg viewBox="0 0 24 24">
              <path
                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>Akun Saya</a></div>
        <div class="menu-item"><a href="/coding web IMK/parfy-php/pesanan"><svg viewBox="0 0 24 24">
              <path
                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
            </svg>Pesanan Saya</a></div>
        <div class="menu-item"><a href="/coding web IMK/parfy-php/alamat"><svg viewBox="0 0 24 24">
              <path
                d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22S19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5Z" />
            </svg>Alamat</a></div>
        <div class="menu-item active"><a href="/coding web IMK/parfy-php/keranjang"><svg viewBox="0 0 24 24">
              <path
                d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
            </svg>Keranjang</a></div>
      </div>
    </div>

    <div class="main" id="main-content">
      <div class="profile-header">
        <div class="icon">👤</div>
        <span>Nama</span>
      </div>

      <a class="btn-back" href="/coding web IMK/parfy-php/dashboard">← Kembali ke Dashboard</a>

      <div class="content-card">
        <h1>Keranjang Belanja</h1>
        <div class="cart-layout">
          <div class="cart-items">
            <!-- Items will be loaded by JS -->
          </div>

          <div class="cart-summary">
            <h3>Ringkasan Belanja</h3>
            <div class="summary-row"><span>Total Harga (3 barang)</span><span>Rp 600.000</span></div>
            <div class="summary-row"><span>Diskon</span><span>Rp 0</span></div>
            <div class="summary-row total"><span>Total Belanja</span><span>Rp 600.000</span></div>
            <button class="btn-checkout" onclick="openCheckout()">Beli Sekarang</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="checkoutOverlay" class="overlay">
    <div class="checkout-box">
      <button class="btn-close-modal" onclick="closeCheckout()">&times;</button>
      <h2 style="text-align:center; margin-bottom:25px;">Konfirmasi Pesanan</h2>

      <div class="checkout-section">
        <h3>📍 Alamat Pengiriman</h3>
        <select id="address-select"
          style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; margin-bottom:15px; font-size:14px;"
          onchange="selectAddress(this.value)">
          <option value="">-- Pilih Alamat --</option>
        </select>
        <div class="addr-box" id="selected-address-display">
          <em style="color:#999;">Pilih alamat pengiriman di atas</em>
        </div>
        <a href="/coding web IMK/parfy-php/alamat" style="display:inline-block; margin-top:10px; font-size:13px; color:#0d3256;">+ Tambah Alamat
          Baru</a>
      </div>

      <div class="checkout-section">
        <h3>🚚 Pengiriman</h3>
        <select id="courier" class="qty-input" style="width:100%; height:40px; border-radius:8px; margin-bottom:10px;"
          onchange="checkShippingCost()">
          <option value="">Pilih Kurir</option>
          <option value="jne">JNE</option>
          <option value="pos">POS Indonesia</option>
          <option value="tiki">TIKI</option>
        </select>
        <div id="shipping-cost-display" style="font-weight:bold; color:#0d3256; text-align:right;">
          Ongkir: -
        </div>
      </div>

      <div class="checkout-section">
        <h3>🛍️ Barang yang Dibeli</h3>
        <div id="checkout-items-container" style="font-size:14px; color:#555;">
          <!-- Items will be loaded here -->
        </div>
      </div>

      <div class="checkout-section">
        <h3>💳 Pembayaran</h3>
        <div style="background:#f0f8ff; padding:15px; border-radius:10px; text-align:center;">
          <div style="font-size:24px; font-weight:bold; color:#0d3256; margin-bottom:10px;">
            🔒 <span style="color:#00AA13;">mid</span><span style="color:#0d3256;">trans</span>
          </div>
          <p style="color:#666; font-size:13px; margin-top:10px;">Pilih pembayaran via popup Midtrans</p>
          <ul style="text-align:left; font-size:12px; color:#555; margin:10px 0 0; padding-left:20px;">
            <li>QRIS (GoPay, OVO, DANA, ShopeePay)</li>
            <li>Transfer Bank (BCA, Mandiri, BNI, BRI, Permata)</li>
            <li>Kartu Kredit/Debit</li>
            <li>Alfamart / Indomaret</li>
          </ul>
        </div>
      </div>

        <div class="summary-row total">
          <span>Total Tagihan</span>
          <span id="checkoutTotalDisplay" style="font-size:20px; color:#0d3256;">Rp 0</span>
        </div>
        <div style="display: flex; gap: 10px;">
          <button class="btn-checkout" style="background: #e2e8f0; color: #1e293b; flex: 1;" onclick="closeCheckout()">Kembali</button>
          <button class="btn-checkout" style="flex: 2;" onclick="processOrder()">💳 Bayar dengan Midtrans</button>
        </div>
      </div>
  </div>

  <!-- Payment Overlay -->
  <div id="paymentOverlay" class="overlay">
    <div class="payment-details-box">
      <button class="btn-close-modal" onclick="cancelPayment()">&times;</button>
      <div id="paymentContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>

  <div id="successOverlay" class="overlay">
    <div class="success-box">
      <div class="success-icon">✅</div>
      <h2>Pesanan Berhasil!</h2>
      <p style="color:#777; margin-bottom:20px;">Pembayaran terkonfirmasi. Kami akan segera mengirimkan parfummu.</p>
      <a href="/coding web IMK/parfy-php/pesanan" class="btn-checkout" style="text-decoration:none; display:inline-block;">Lihat Pesanan Saya</a>
    </div>
  </div>


  <!-- Midtrans Snap JS -->
  <?php require_once __DIR__ . '/../config/midtrans.php'; ?>
  <script src="<?php echo MIDTRANS_SNAP_URL; ?>" data-client-key="<?php echo MIDTRANS_CLIENT_KEY; ?>"></script>
  <script src="/coding web IMK/parfy-php/js/api.js"></script>
  <script>
    let cartItems = [];
    let userAddresses = [];
    let checkoutTotal = 0;
    let currentShippingCost = 0;

    // Check if user is logged in
    function checkAuth() {
      // Safety check for API loading
      if (typeof PARFY === 'undefined') {
        console.error('PARFY API not loaded');
        Swal.fire('Error!', 'System Error: API failed to load. Please refresh.', 'error');
        return false;
      }

      const user = PARFY.getUser();
      if (!user) {
        window.location.href = '/coding web IMK/parfy-php/login';
        return false;
      }
      document.querySelector('.profile-header span').textContent = user.name || 'User';
      return true;
    }

    // Format price
    function formatPrice(price) {
      return 'Rp ' + price.toLocaleString('id-ID');
    }

    // Render cart items
    function renderCart() {
      const container = document.querySelector('.cart-items');

      if (!container) {
        console.error('Container .cart-items not found!');
        return;
      }

      console.log('Rendering cart items:', cartItems);

      if (!cartItems || cartItems.length === 0) {
        container.innerHTML = `
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <div style="font-size:60px; margin-bottom:20px;">🛒</div>
            <h3>Keranjang Kosong</h3>
            <p>Yuk mulai belanja parfum favoritmu!</p>
            <a href="/coding web IMK/parfy-php/dashboard" class="btn-checkout" style="text-decoration:none; display:inline-block; margin-top:15px;">Belanja Sekarang</a>
          </div>
        `;
        updateSummary();
        return;
      }

      try {
        container.innerHTML = cartItems.map((item, index) => {
          // Handle image - could be JSON array or single string
          let productImage = '/foto/default.jpg';
          if (item.product) {
            if (Array.isArray(item.product.images) && item.product.images[0]) {
              productImage = item.product.images[0];
            } else if (item.product.image) {
              // Try to parse as JSON array if it's a string
              try {
                const parsed = JSON.parse(item.product.image);
                productImage = Array.isArray(parsed) && parsed[0] ? parsed[0] : item.product.image;
              } catch (e) {
                productImage = item.product.image;
              }
            }
          }

          return `
            <div class="cart-item" data-id="${item.productId}">
              <div class="checkbox-wrapper"><input type="checkbox" checked onchange="updateSummary()"></div>
              <img src="${productImage}" alt="${item.product?.name || 'Produk'}" class="item-img" onerror="this.onerror=null; this.src='/coding web IMK/parfy-php/foto/default.jpg';">
              <div class="item-details">
                <h4>${item.product?.name || 'Produk'}</h4>
                <div class="variant">Qty: ${item.quantity}</div>
                <div class="price">${formatPrice(item.product?.price || 0)}</div>
              </div>
              <div class="qty-control">
                <button class="qty-btn" onclick="updateQty('${item.productId}', -1)">-</button>
                <input type="text" value="${item.quantity}" class="qty-input" readonly>
                <button class="qty-btn" onclick="updateQty('${item.productId}', 1)">+</button>
              </div>
              <button class="btn-delete" onclick="removeItem('${item.productId}')">🗑️</button>
            </div>
          `;
        }).join('');
      } catch (err) {
        console.error('Error rendering items:', err);
        container.innerHTML = `<p style="color:red">Error rendering items: ${err.message}</p>`;
      }

      updateSummary();
    }

    // Update quantity
    async function updateQty(productId, change) {
      const item = cartItems.find(i => i.productId === productId);
      if (!item) return;

      const newQty = item.quantity + change;
      if (newQty < 1) {
        removeItem(productId);
        return;
      }

      try {
        await PARFY.cart.update(productId, newQty);
        await loadCart();
      } catch (error) {
        Swal.fire('Error!', error.message, 'error');
      }
    }

    // Remove item
    async function removeItem(productId) {
        const result = await Swal.fire({ title: 'Hapus produk ini dari keranjang?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya!', cancelButtonText: 'Batal' });
        if (!result.isConfirmed) return;

      try {
        await PARFY.cart.remove(productId);
        await loadCart();
      } catch (error) {
        Swal.fire('Error!', error.message, 'error');
      }
    }

    // Update summary
    function updateSummary() {
      const checkedItems = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
      let total = 0;
      let itemCount = 0;

      checkedItems.forEach(checkbox => {
        const cartItem = checkbox.closest('.cart-item');
        const productId = cartItem.dataset.id;
        const item = cartItems.find(i => i.productId === productId);
        if (item) {
          total += (item.product?.price || 0) * item.quantity;
          itemCount += item.quantity;
        }
      });

      // Fix selector: Use .cart-summary to scope it, and find rows
      const summaryBox = document.querySelector('.cart-summary');
      if (summaryBox) {
        const rows = summaryBox.querySelectorAll('.summary-row');
        if (rows.length >= 1) {
          rows[0].querySelector('span:last-child').textContent = formatPrice(total);
          rows[0].querySelector('span:first-child').textContent = `Total Harga (${itemCount} barang)`;
        }
        if (rows.length >= 3) { // Total row is usually the 3rd row (index 2) or has .total class
          const totalRow = summaryBox.querySelector('.summary-row.total');
          if (totalRow) totalRow.querySelector('span:last-child').textContent = formatPrice(total);
        }
      }
    }

    // Open checkout
    function openCheckout() {
      const checkedItems = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
      if (checkedItems.length === 0) {
        Swal.fire('Peringatan!', 'Pilih minimal satu produk untuk checkout!', 'warning');
        return;
      }

      // Update checkout summary
      let itemsHtml = '';
      let total = 0;

      checkedItems.forEach(checkbox => {
        const cartItem = checkbox.closest('.cart-item');
        const productId = cartItem.dataset.id;
        const item = cartItems.find(i => i.productId === productId);
        if (item) {
          const subtotal = (item.product?.price || 0) * item.quantity;
          itemsHtml += `<div style="display:flex; justify-content:space-between; margin-bottom:5px;">
            <span>${item.quantity}x ${item.product?.name}</span><span>${formatPrice(subtotal)}</span>
          </div>`;
          total += subtotal;
        }
      });

      document.getElementById('checkout-items-container').innerHTML = itemsHtml + `
        <div style="margin-top:10px; text-align:right;">
            <a href="#" onclick="closeCheckout(); return false;" style="display:inline-block; font-size:13px; color:var(--btn-bg); text-decoration:none; font-weight:600; padding:5px 15px; border:1px solid var(--btn-bg); border-radius:5px; transition:0.3s; background:white;">
               + Ubah / Tambah Produk
            </a>
        </div>
      `;
      document.querySelector('#checkoutOverlay .summary-row.total span:last-child').textContent = formatPrice(total);

      // Store total global
      checkoutTotal = total;

      // Load user address
      loadUserAddress();

      // Reset shipping
      currentShippingCost = 0;
      document.getElementById('shipping-cost-display').textContent = 'Ongkir: -';
      document.getElementById('courier').value = "";

      document.getElementById('checkoutOverlay').style.display = 'flex';
    }

    // Check shipping cost using saved address (BinderByte)
    async function checkShippingCost() {
      const courierEl = document.getElementById('courier');
      if (courierEl) courierEl.style.border = '';
      const courier = courierEl ? courierEl.value : '';
      const display = document.getElementById('shipping-cost-display');

      if (!courier) {
        currentShippingCost = 0;
        display.textContent = 'Ongkir: -';
        updateCheckoutTotal();
        return;
      }

      if (selectedAddressIndex < 0 || !userAddresses[selectedAddressIndex] || !userAddresses[selectedAddressIndex].cityId) {
        Swal.fire('Informasi', 'Mohon pilih alamat pengiriman yang lengkap (Kota & Provinsi) agar bisa menghitung ongkir.', 'info');
        return;
      }

      const cityDest = userAddresses[selectedAddressIndex].cityId;

      display.textContent = 'Hitung ongkir...';

      try {
        const res = await fetch('/coding web IMK/parfy-php/api/shipping/cost.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            destination: cityDest,
            weight: 1000,
            courier: courier
          })
        });
        const data = await res.json();

        // BinderByte response format
        if (data.success && data.costs && data.costs.length > 0) {
          const service = data.costs[0];
          const cost = service.cost;
          const serviceName = service.service;
          currentShippingCost = cost;
          display.textContent = `Ongkir (${serviceName}): ${formatPrice(cost)}`;
        } else {
          display.textContent = data.error || 'Layanan tidak tersedia';
          console.error('BinderByte error:', data);
          currentShippingCost = 0;
        }
      } catch (e) {
        display.textContent = 'Gagal cek ongkir';
        console.error('Error:', e);
        currentShippingCost = 0;
      }
      updateCheckoutTotal();
    }

    function updateCheckoutTotal() {
      const finalTotal = checkoutTotal + currentShippingCost;
      document.querySelector('#checkoutOverlay .summary-row.total span:last-child').textContent = formatPrice(finalTotal);
    }

    // Load user address for checkout
    async function loadUserAddress() {
      try {
        const user = await PARFY.users.me();

        // Fetch addresses from dedicated API
        const res = await fetch('/coding web IMK/parfy-php/api/users/addresses.php', {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('parfy_token')
          }
        });
        userAddresses = await res.json();
        if (!Array.isArray(userAddresses)) userAddresses = [];

        const addrSelect = document.getElementById('address-select');
        const addrDisplay = document.getElementById('selected-address-display');

        if (userAddresses.length > 0) {
          // Populate dropdown with saved addresses
          addrSelect.innerHTML = '<option value="">-- Pilih Alamat --</option>' +
            userAddresses.map((addr, idx) => {
              const labelPrefix = addr.label && addr.label.trim() ? `${addr.label} - ` : '';
              const citySuffix = addr.city && addr.city.trim() ? ` (${addr.city})` : '';
              return `<option value="${idx}">${labelPrefix}${addr.name || 'Penerima'}${citySuffix}</option>`;
            }).join('');

          // Auto-select first address
          addrSelect.value = '0';
          selectAddress('0');
        } else {
          addrSelect.innerHTML = '<option value="">-- Belum ada alamat --</option>';
          addrDisplay.innerHTML = `
            <div style="color:#dc3545; margin-bottom:10px;">
              <strong>Belum ada alamat pengiriman</strong>
            </div>
            <a href="/coding web IMK/parfy-php/alamat" class="btn-checkout" style="text-decoration:none; background:#6c757d; font-size:14px; padding:5px 15px;">+ Tambah Alamat</a>
          `;
        }
      } catch (error) {
        console.error('Error loading address:', error);
      }
    }

    // Select address from dropdown
    let selectedAddressIndex = 0;
    function selectAddress(index) {
      if (index === '' || userAddresses.length === 0) {
        document.getElementById('selected-address-display').innerHTML = '<em style="color:#999;">Pilih alamat pengiriman di atas</em>';
        selectedAddressIndex = -1;
        return;
      }

      selectedAddressIndex = parseInt(index);
      const addr = userAddresses[selectedAddressIndex];
      const labelText = addr.label && addr.label.trim() ? addr.label : 'Alamat';
      const namePart = addr.name && addr.name.trim() ? ` (${addr.name})` : '';
      const addressParts = [addr.street, addr.city, addr.province].filter(p => p && p.trim() !== '');
      const fullAddressStr = addressParts.join(', ') + (addr.postalCode ? ' ' + addr.postalCode : '');

      document.getElementById('selected-address-display').innerHTML = `
        <strong>${labelText}${namePart}</strong><br>
        ${addr.phone || '-'}<br>
        ${fullAddressStr}
      `;

      // Reset and recalculate shipping if courier already selected
      const courier = document.getElementById('courier').value;
      if (courier) {
        checkShippingCost();
      }
    }

    // Close checkout
    function closeCheckout() {
      document.getElementById('checkoutOverlay').style.display = 'none';
      document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected'));
      document.querySelectorAll('input[name="payment_method"]').forEach(r => r.checked = false);
    }

    // Select payment method
    function selectPayment(id) {
      document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected'));
      document.getElementById(id).classList.add('selected');
      document.getElementById(id).querySelector('input').checked = true;
    }

    // Process order - Using Midtrans Snap
    async function processOrder() {
      // Check if address exists
      if (userAddresses.length === 0) {
        Swal.fire('Error!', "⚠️ Mohon tambahkan alamat pengiriman terlebih dahulu sebelum checkout!", 'error');
        window.location.href = '/coding web IMK/parfy-php/alamat';
        return;
      }

      // Check shipping / courier selection
      const courierSelect = document.getElementById('courier');
      if (!courierSelect || !courierSelect.value || currentShippingCost <= 0) {
        Swal.fire({
          title: 'Pengiriman Belum Dipilih!',
          text: 'Mohon pilih kurir pengiriman terlebih dahulu sebelum melanjutkan pembayaran.',
          icon: 'warning',
          confirmButtonText: 'Pilih Kurir'
        });
        if (courierSelect) {
          courierSelect.focus();
          courierSelect.style.border = '2px solid #dc3545';
        }
        return;
      }

      // Get selected items
      const checkedItems = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
      if (checkedItems.length === 0) {
        Swal.fire('Peringatan!', "⚠️ Pilih minimal 1 item untuk checkout!", 'warning');
        return;
      }

      const items = [];
      checkedItems.forEach(checkbox => {
        const cartItem = checkbox.closest('.cart-item');
        const productId = cartItem.dataset.id;
        const item = cartItems.find(i => i.productId === productId);
        if (item) {
          items.push({ productId: item.productId, quantity: item.quantity });
        }
      });

      // Prepare checkout data
      const orderData = {
        items: items,
        paymentMethod: 'midtrans',
        shippingAddress: document.querySelector('.addr-box').textContent,
        shippingCost: currentShippingCost
      };

      try {
        // 1. Create transaction first
        const checkoutBtn = document.querySelector('.btn-checkout[onclick="processOrder()"]');
        checkoutBtn.disabled = true;
        checkoutBtn.textContent = '⏳ Memproses...';

        const checkoutResult = await PARFY.transactions.checkout(orderData);
        const transactionId = checkoutResult.transaction.id;

        // 2. Get Midtrans Snap token
        const paymentResult = await PARFY.payment.createPayment(transactionId);

        checkoutBtn.disabled = false;
        checkoutBtn.textContent = '🔒 Bayar dengan Midtrans';

        // 3. Open Midtrans Snap popup
        window.snap.pay(paymentResult.token, {
          onSuccess: async function (result) {
            console.log('Payment success:', result);
            try {
              await fetch('/coding web IMK/parfy-php/api/payment/confirm.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': 'Bearer ' + (localStorage.getItem('parfy_token') || '')
                },
                body: JSON.stringify({
                  transaction_id: transactionId,
                  midtrans_result: result
                })
              });
            } catch (e) {
              console.error('Confirm error:', e);
            }
            document.getElementById('checkoutOverlay').style.display = 'none';
            document.getElementById('successOverlay').style.display = 'flex';
            loadCart(); // Refresh cart
          },
          onPending: function (result) {
            console.log('Payment pending:', result);
            Swal.fire('Informasi', 'Pembayaran pending. Silakan selesaikan pembayaran Anda.', 'info');
            window.location.href = '/coding web IMK/parfy-php/pesanan';
          },
          onError: function (result) {
            console.log('Payment error:', result);
            Swal.fire('Error!', 'Pembayaran gagal. Silakan coba lagi.', 'error');
          },
          onClose: function () {
            console.log('Snap popup closed');
            // User closed without completing payment - go back to checkout
            document.getElementById('checkoutOverlay').style.display = 'flex';
            Swal.fire('Informasi', 'Pembayaran dibatalkan. Pesanan Anda masih tersimpan dengan status "Menunggu Pembayaran".\n\nAnda bisa melanjutkan pembayaran nanti di halaman Pesanan Saya.', 'info');
          }
        });

      } catch (error) {
        console.error('Checkout error:', error);
        Swal.fire('Error!', error.message, 'error');
        const checkoutBtn = document.querySelector('.btn-checkout[onclick="processOrder()"]');
        if (checkoutBtn) {
          checkoutBtn.disabled = false;
          checkoutBtn.textContent = '🔒 Bayar dengan Midtrans';
        }
      }
    }

    // Pending order data for confirmation
    let pendingOrderData = null;
    let paymentTimerInterval = null;

    // Start countdown timer
    function startPaymentTimer(totalSeconds) {
      // Clear any existing timer
      if (paymentTimerInterval) {
        clearInterval(paymentTimerInterval);
      }

      let remaining = totalSeconds;
      const timerElement = document.getElementById('paymentTimerDisplay');

      function updateTimer() {
        if (remaining <= 0) {
          clearInterval(paymentTimerInterval);
          timerElement.textContent = '⏱️ Waktu habis!';
          timerElement.style.color = '#dc3545';
          // Auto cancel after timeout
          setTimeout(() => {
            Swal.fire('Error!', 'Waktu pembayaran habis. Silakan ulangi checkout.', 'error');
            cancelPayment();
          }, 1500);
          return;
        }

        const hours = Math.floor(remaining / 3600);
        const minutes = Math.floor((remaining % 3600) / 60);
        const seconds = remaining % 60;

        let timeStr = '';
        if (hours > 0) {
          timeStr = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        } else {
          timeStr = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        timerElement.textContent = `⏱️ Berlaku ${timeStr}`;
        remaining--;
      }

      updateTimer(); // Initial call
      paymentTimerInterval = setInterval(updateTimer, 1000);
    }

    // Show payment details based on method
    function showPaymentDetails(method) {
      const contentDiv = document.getElementById('paymentContent');
      const finalTotal = checkoutTotal + currentShippingCost;

      // Prepare order data
      const checkedItems = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
      const items = [];
      checkedItems.forEach(checkbox => {
        const cartItem = checkbox.closest('.cart-item');
        const productId = cartItem.dataset.id;
        const item = cartItems.find(i => i.productId === productId);
        if (item) {
          items.push({ productId: item.productId, quantity: item.quantity });
        }
      });

      pendingOrderData = {
        items: items,
        paymentMethod: method,
        shippingAddress: document.querySelector('.addr-box').textContent,
        shippingCost: currentShippingCost
      };

      if (method === 'QRIS') {
        contentDiv.innerHTML = `
          <h2 style="margin-bottom: 10px;">💳 Pembayaran QRIS</h2>
          <p style="color: var(--muted-text);">Scan QR Code dengan E-Wallet Anda</p>
          <div class="qr-container">
            <img src/assets/qris_parfy.png" alt="QRIS Code" onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PARFY-DEMO-${Date.now()}'">
          </div>
          <div class="payment-timer" id="paymentTimerDisplay">⏱️ Berlaku 15:00</div>
          <div style="font-size: 20px; font-weight: bold; color: var(--btn-bg);">
            Total: ${formatPrice(finalTotal)}
          </div>
          <button class="btn-confirm-payment" onclick="confirmPayment()">✅ Saya Sudah Bayar</button>
          <button class="btn-cancel-payment" onclick="cancelPayment()">Batalkan Pembayaran</button>
        `;
        // Start 15 minute timer (900 seconds)
        startPaymentTimer(15 * 60);
      } else {
        contentDiv.innerHTML = `
          <h2 style="margin-bottom: 10px;">🏦 Transfer Bank</h2>
          <p style="color: var(--muted-text);">Pilih bank dan transfer ke nomor VA berikut</p>
          <div class="va-container">
            <select id="bankSelect" class="bank-select" onchange="updateVANumber()">
              <option value="BCA">BCA</option>
              <option value="Mandiri">Mandiri</option>
              <option value="BRI">BRI</option>
              <option value="BNI">BNI</option>
            </select>
            <div id="vaDisplay" class="va-number">8881234567890123</div>
            <small style="color: var(--muted-text);">a.n. PARFY.ID</small>
          </div>
          <div class="payment-timer" id="paymentTimerDisplay">⏱️ Berlaku 24:00:00</div>
          <div style="font-size: 20px; font-weight: bold; color: var(--btn-bg);">
            Total: ${formatPrice(finalTotal)}
          </div>
          <button class="btn-confirm-payment" onclick="confirmPayment()">✅ Saya Sudah Bayar</button>
          <button class="btn-cancel-payment" onclick="cancelPayment()">Batalkan Pembayaran</button>
        `;
        updateVANumber();
        // Start 24 hour timer (86400 seconds) - for demo, use 5 minutes
        startPaymentTimer(24 * 60 * 60);
      }

      document.getElementById('checkoutOverlay').style.display = 'none';
      document.getElementById('paymentOverlay').style.display = 'flex';
    }

    // Update VA number based on bank selection
    function updateVANumber() {
      const bank = document.getElementById('bankSelect').value;
      const vaNumbers = {
        'BCA': '88810081234567890',
        'Mandiri': '88920001234567890',
        'BRI': '88810021234567890',
        'BNI': '88100001234567890'
      };
      document.getElementById('vaDisplay').textContent = vaNumbers[bank] || '8881234567890123';
    }

    // Confirm payment and finalize order
    async function confirmPayment() {
      // Clear timer
      if (paymentTimerInterval) {
        clearInterval(paymentTimerInterval);
        paymentTimerInterval = null;
      }

      if (!pendingOrderData) {
        Swal.fire('Error!', 'Error: Data pesanan tidak ditemukan', 'error');
        return;
      }

      try {
        await PARFY.transactions.checkout(pendingOrderData);

        document.getElementById('paymentOverlay').style.display = 'none';
        document.getElementById('successOverlay').style.display = 'flex';

        pendingOrderData = null;
        await loadCart();
      } catch (error) {
        Swal.fire('Error!', error.message, 'error');
      }
    }

    // Cancel payment and go back to checkout
    function cancelPayment() {
      // Clear timer
      if (paymentTimerInterval) {
        clearInterval(paymentTimerInterval);
        paymentTimerInterval = null;
      }

      document.getElementById('paymentOverlay').style.display = 'none';
      document.getElementById('checkoutOverlay').style.display = 'flex';
      pendingOrderData = null;
    }

    // Load cart from API
    async function loadCart() {
      try {
        const data = await PARFY.cart.get();
        cartItems = data.items || [];
        renderCart();
      } catch (error) {
        console.error('Error loading cart:', error);
      }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
      // Reset all overlays on page load to prevent auto-open on refresh
      document.getElementById('checkoutOverlay').style.display = 'none';
      document.getElementById('paymentOverlay').style.display = 'none';
      document.getElementById('successOverlay').style.display = 'none';

      if (checkAuth()) {
        loadCart();
      }
    });

    // Mobile sidebar toggle
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      const overlay = document.querySelector('.sidebar-overlay');
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
    }
  </script>
</body>

</html>