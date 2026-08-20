<?php require_once __DIR__ . '/../config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesanan Saya</title>
  <style>
    /* --- CSS GLOBAL (Sama dengan Referensi) --- */
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
      transition: background 0.3s, color 0.3s, transform 0.3s;
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

    /* SVG Icon Styling */
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

    /* Profile Header (Top Right) */
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
      transition: background 0.3s;
    }

    .profile-header:hover {
      cursor: pointer;
      opacity: 0.9;
    }

    .profile-dropdown {
      position: absolute;
      top: 60px;
      right: 0;
      background: white;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
      min-width: 160px;
      padding: 5px 0;
      display: none;
      z-index: 1000;
      overflow: hidden;
    }

    .profile-dropdown.show {
      display: block;
      animation: fadeIn 0.2s ease;
    }

    .profile-dropdown a {
      display: block;
      padding: 10px 20px;
      text-decoration: none;
      color: var(--text-color);
      font-size: 14px;
      transition: background 0.2s;
    }

    .profile-dropdown a:hover {
      background: #f5f5f5;
    }

    .profile-dropdown a.logout-btn {
      color: #dc3545;
    }

    .profile-dropdown a.logout-btn:hover {
      background: #fff5f5;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Content Card */
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

    /* --- Styles Khusus Pesanan --- */
    .order-list {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .order-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s;
    }

    .order-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .order-left {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .order-img {
      width: 80px;
      height: 80px;
      border-radius: 10px;
      object-fit: cover;
      background-color: #ddd;
      /* Fallback color */
    }

    .order-info h4 {
      margin: 0 0 8px 0;
      font-size: 18px;
      color: var(--text-color);
    }

    .order-info p {
      margin: 0;
      color: var(--muted-text);
      font-size: 14px;
    }

    .status-badge {
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 600;
      text-align: center;
    }

    /* Status Colors */
    .status-packed {
      background: #fff3cd;
      color: #856404;
    }

    .status-shipping {
      background: #d4edda;
      color: #155724;
    }

    .status-done {
      background: #cce5ff;
      color: #004085;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar {
        width: 250px;
        padding: 30px 20px;
      }

      .main {
        padding: 30px 40px;
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
        text-decoration: none;
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

      .order-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .status-badge {
        align-self: flex-start;
      }
    }

    /* Mobile header hidden by default */
    .mobile-header {
      display: none;
    }

    .sidebar-overlay {
      display: none;
    }
  </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!-- Mobile Header -->
  <div class="mobile-header">
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
    <span class="page-title">Pesanan Saya</span>
    <div class="mobile-icons">
      <a href="<?php echo url('/dashboard'); ?>">🏠</a>
      <a href="<?php echo url('/keranjang'); ?>">🛒</a>
    </div>
  </div>

  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

  <div class="container">
    <div class="sidebar">
      <div class="logo">
        <img src="<?php echo url('/assets/'); ?>logo_parfum_bk.png" alt="Logo">
        <h2>PARFY.ID</h2>
        <p>TOKO PARFUM TERMURAH</p>
      </div>

      <div class="menu">
        <div class="menu-item" data-page="akun">
          <a href="<?php echo url('/akun'); ?>">
            <svg viewBox="0 0 24 24">
              <path
                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            Akun Saya
          </a>
        </div>
        <div class="menu-item active" data-page="pesanan">
          <a href="<?php echo url('/pesanan'); ?>">
            <svg viewBox="0 0 24 24">
              <path
                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
            </svg>
            Pesanan Saya
          </a>
        </div>
        <div class="menu-item" data-page="alamat">
          <a href="<?php echo url('/alamat'); ?>">
            <svg viewBox="0 0 24 24">
              <path
                d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22S19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5Z" />
            </svg>
            Alamat
          </a>
        </div>
        <div class="menu-item" data-page="keranjang">
          <a href="<?php echo url('/keranjang'); ?>">
            <svg viewBox="0 0 24 24">
              <path
                d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
            </svg>
            Keranjang
          </a>
        </div>
      </div>
    </div>

    <div class="main" id="main-content">
      <div class="profile-header" onclick="toggleProfileMenu(event)">
        <div class="icon">👤</div>
        <span id="profileName">User</span> &nbsp; <span style="font-size:12px">▼</span>

        <div class="profile-dropdown" id="profileDropdown">
          <a href="<?php echo url('/keranjang'); ?>">Keranjang</a>
          <div style="height:1px; background:#eee; margin:5px 0;"></div>
          <a href="#" class="logout-btn" onclick="PARFY.auth.logout()">Keluar</a>
        </div>
      </div>

      <a class="btn-back" href="<?php echo url('/dashboard'); ?>">← Kembali ke Dashboard</a>

      <div class="content-card">
        <h1>Pesanan Saya</h1>
        <p style="color:var(--muted-text); margin-bottom: 25px;">Riwayat belanja parfum kamu.</p>

        <div class="order-list" id="orderList">
          <!-- Orders will be loaded from API -->
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <div class="spinner"
              style="width:40px;height:40px;border:4px solid #ddd;border-top:4px solid var(--btn-bg);border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 20px;">
            </div>
            <p>Memuat pesanan...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


  <!-- Review Modal -->
  <div id="reviewModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeReviewModal()">&times;</span>
      <h3 style="margin-top:0;">Beri Ulasan</h3>
      <p id="reviewProductName" style="font-weight:600;"></p>
      
      <div style="margin-bottom: 15px; text-align:center; font-size: 2.5rem; color: #ccc; cursor:pointer;" id="starRating">
         <span data-val="1">★</span><span data-val="2">★</span><span data-val="3">★</span><span data-val="4">★</span><span data-val="5">★</span>
      </div>
      <input type="hidden" id="reviewRating" value="5">

      <textarea id="reviewComment" rows="4" placeholder="Bagaimana kualitas produk ini?" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; margin-bottom:20px; box-sizing:border-box;"></textarea>
      
      <div style="display:flex; justify-content:end; gap:10px;">
        <button onclick="closeReviewModal()" style="padding:10px 20px; background:#ddd; border:none; border-radius:8px; cursor:pointer;">Batal</button>
        <button onclick="submitReview()" style="padding:10px 20px; background:var(--btn-bg); color:white; border:none; border-radius:8px; cursor:pointer;">Kirim Ulasan</button>
      </div>
    </div>
  </div>

  <!-- Cancel Modal -->
  <div id="cancelModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeCancelModal()">&times;</span>
      <h3 style="margin-top:0;">Batalkan Pesanan</h3>
      <p>Pilih alasan pembatalan:</p>
      <select id="cancelReason"
        style="width:100%; padding: 10px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ccc;">
        <option value="Ingin mengubah alamat">Ingin mengubah alamat</option>
        <option value="Ingin mengubah pesanan">Ingin mengubah pesanan</option>
        <option value="Berubah pikiran">Berubah pikiran</option>
        <option value="Dibatalkan oleh penjual">Lainnya</option>
      </select>
      <div style="display:flex; justify-content:end; gap:10px;">
        <button onclick="closeCancelModal()"
          style="padding:10px 20px; background:#ddd; border:none; border-radius:8px; cursor:pointer;">Batal</button>
        <button onclick="submitCancel()"
          style="padding:10px 20px; background:#dc3545; color:white; border:none; border-radius:8px; cursor:pointer;">Konfirmasi</button>
      </div>
    </div>
  </div>

  <style>
    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .status-pending {
      background: #fff3cd;
      color: #856404;
    }

    .status-processing {
      background: #d4edda;
      color: #155724;
    }

    .status-shipped {
      background: #cce5ff;
      color: #004085;
    }

    .status-delivered {
      background: #d1e7dd;
      color: #0a3622;
    }

    .status-cancelled {
      background: #f8d7da;
      color: #721c24;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      align-items: center;
      justify-content: center;
    }

    .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      width: 90%;
      max-width: 400px;
      position: relative;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 24px;
      cursor: pointer;
      color: #999;
    }

    .cancel-btn {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      margin-left: auto;
    }


    .cancel-btn:hover {
      background-color: #c82333;
    }

    .btn-review {
      background-color: #ffc107;
      color: #000;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      margin-left: auto;
      font-weight: 600;
    }
    .btn-review:hover {
      background-color: #e0a800;
    }

  </style>

  <script src="<?php echo url('/js/api.js'); ?>"></script>
  <script>
    // Check if user is logged in
    function checkAuth() {
      const user = PARFY.getUser();
      if (!user) {
        window.location.href = BASE_PATH + '/login';
        return false;
      }
      document.querySelector('#profileName').textContent = user.name || 'User';
      return true;
    }

    function toggleProfileMenu(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('profileDropdown');
      dropdown.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    window.onclick = function (event) {
      if (!event.target.closest('.profile-header')) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && dropdown.classList.contains('show')) {
          dropdown.classList.remove('show');
        }
      }
    }

    // Format price
    function formatPrice(price) {
      return 'Rp ' + price.toLocaleString('id-ID');
    }

    // Get status class and label
    function getStatusInfo(status) {
      const statusMap = {
        'pending': { class: 'status-pending', label: 'Menunggu Konfirmasi' },
        'processing': { class: 'status-processing', label: 'Dikemas' },
        'shipped': { class: 'status-shipped', label: 'Dalam Pengiriman' },
        'delivered': { class: 'status-delivered', label: 'Selesai' },
        'cancelled': { class: 'status-cancelled', label: 'Dibatalkan' }
      };
      return statusMap[status] || { class: 'status-pending', label: status };
    }

    // Render orders
    function renderOrders(orders) {
      const container = document.getElementById('orderList');

      if (orders.length === 0) {
        container.innerHTML = `
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <div style="font-size:60px; margin-bottom:20px;">📦</div>
            <h3>Belum ada pesanan</h3>
            <p>Pesananmu akan muncul di sini setelah checkout.</p>
            <a href="<?php echo url('/dashboard'); ?>" style="
              text-decoration:none; 
              display:inline-block; 
              margin-top:15px;
              background:var(--btn-bg);
              color:white;
              padding:12px 25px;
              border-radius:8px;
            ">Mulai Belanja</a>
          </div>
        `;
        return;
      }

      container.innerHTML = orders.map(order => {
        const statusInfo = getStatusInfo(order.status);
        const firstItem = order.items && order.items.length > 0 ? order.items[0] : null;
        
        // Handle image - could be JSON array or single string
        let productImage = '/coding web IMK/parfy-php/foto/default.jpg';
        if (firstItem?.product) {
            if (Array.isArray(firstItem.product.images) && firstItem.product.images[0]) {
                productImage = firstItem.product.images[0];
            } else if (firstItem.product.image) {
                try {
                    const parsed = JSON.parse(firstItem.product.image);
                    productImage = Array.isArray(parsed) && parsed[0] ? parsed[0] : firstItem.product.image;
                } catch(e) {
                    productImage = firstItem.product.image;
                }
            }
        }
        
        const itemCount = (order.items || []).reduce((sum, i) => sum + (i.quantity || 1), 0);
        const isPaid = order.paymentStatus === 'lunas' || order.paymentStatus === 'paid';
        const orderDate = order.createdAt || order.date ? new Date(order.createdAt || order.date).toLocaleDateString('id-ID') : '-';

        return `
          <div class="order-item">
            <div class="order-left">
              <img src="${productImage}" alt="produk" class="order-img" onerror="this.onerror=null; this.src='<?php echo url('/assets/default.jpg'); ?>'">
              <div class="order-info">
                <h4>${firstItem?.product?.name || firstItem?.productName || 'Produk'}${order.items && order.items.length > 1 ? ` +${order.items.length - 1} lainnya` : ''}</h4>
                <p>Qty: ${itemCount} · Total: ${formatPrice(order.total)}</p>
                <p style="font-size:12px; color:#999;">${orderDate} · <span style="color:${isPaid ? '#28a745' : '#856404'}; font-weight:600;">${isPaid ? '✓ Lunas' : 'Menunggu Pembayaran'}</span></p>
              </div>
            </div>
            <div style="display:flex; flex-direction:column; align-items:end; gap:10px;">
                <div class="status-badge ${statusInfo.class}">
                  ${statusInfo.label}
                </div>
                ${order.status === 'pending' ? `<button class="cancel-btn" onclick="openCancelModal('${order.id}')">Batalkan</button>` : ''}
                ${order.status === 'delivered' ? `<button class="btn-review" onclick="openReviewModal('${firstItem?.product?.id}', '${(firstItem?.product?.name || '').replace(/'/g, "\\'")}')">Beri Ulasan</button>` : ''}
            </div>
          </div>
        `;
      }).join('');
    }

    // Load orders from API
    async function loadOrders() {
      try {
        const orders = await PARFY.transactions.myOrders();
        renderOrders(orders);
      } catch (error) {
        console.error('Error loading orders:', error);
        document.getElementById('orderList').innerHTML = `
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <p>Gagal memuat pesanan. <a href="#" onclick="loadOrders()">Coba lagi</a></p>
          </div>
        `;
      }
    }


    // Review Logic
    let currentReviewProductId = null;

    function openReviewModal(productId, productName) {
        if (!productId || productId === 'undefined') {
            Swal.fire('Error', 'ID Produk tidak valid.', 'error');
            return;
        }
        currentReviewProductId = productId;
        document.getElementById('reviewProductName').textContent = productName;
        document.getElementById('reviewModal').style.display = 'flex';
        setStars(5);
        document.getElementById('reviewComment').value = '';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
        currentReviewProductId = null;
    }

    document.querySelectorAll('#starRating span').forEach(star => {
        star.addEventListener('click', function() {
            const val = this.getAttribute('data-val');
            setStars(val);
        });
    });

    function setStars(rating) {
        document.getElementById('reviewRating').value = rating;
        document.querySelectorAll('#starRating span').forEach(star => {
            if (parseInt(star.getAttribute('data-val')) <= parseInt(rating)) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ccc';
            }
        });
    }

    
    async function submitReview() {
        if (!currentReviewProductId) return;
        const rating = parseInt(document.getElementById('reviewRating').value);
        const comment = document.getElementById('reviewComment').value.trim();

        if (!comment) {
            Swal.fire('Info', 'Mohon isi komentar ulasan Anda.', 'info');
            return;
        }

        Swal.fire({
            title: 'Mengirim Ulasan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            await PARFY.reviews.create(currentReviewProductId, '', rating, comment);
            Swal.fire('Berhasil!', 'Terima kasih atas ulasan Anda!', 'success');
            closeReviewModal();
        } catch (error) {
            Swal.fire('Error!', 'Gagal mengirim ulasan: ' + error.message, 'error');
        }
    }
// Modal Logic

    let currentOrderIdDetails = null;

    function openCancelModal(orderId) {
      currentOrderIdDetails = orderId;
      document.getElementById('cancelModal').style.display = 'flex';
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').style.display = 'none';
      currentOrderIdDetails = null;
    }

    async function submitCancel() {
      if (!currentOrderIdDetails) return;

      const reason = document.getElementById('cancelReason').value;
      try {
        await PARFY.transactions.cancelOrder(currentOrderIdDetails, reason);
        Swal.fire('Berhasil!', 'Pesanan berhasil dibatalkan', 'success');
        closeCancelModal();
        loadOrders(); // Refresh list
      } catch (error) {
        Swal.fire('Error!', 'Gagal membatalkan: ' + error.message, 'error');
      }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
      if (checkAuth()) {
        loadOrders();
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
