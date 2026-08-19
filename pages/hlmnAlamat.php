<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alamat Saya</title>
  <style>
    /* --- CSS GLOBAL (Sama dengan Halaman Akun & Pesanan) --- */
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

    /* --- Styles Khusus Halaman Alamat --- */

    .top-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .btn-add {
      background: var(--btn-bg);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: opacity 0.3s;
    }

    .btn-add:hover {
      opacity: 0.9;
    }

    .address-list {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .address-card {
      background: white;
      padding: 25px;
      border-radius: 15px;
      border: 1px solid transparent;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      position: relative;
      transition: 0.3s;
    }

    .address-card:hover {
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      border-color: #ddd;
    }

    .badge-main {
      background: #e3f2fd;
      color: #0d3256;
      padding: 4px 12px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: bold;
      margin-left: 10px;
    }

    .addr-name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 5px;
      display: flex;
      align-items: center;
    }

    .addr-phone {
      color: var(--muted-text);
      font-size: 14px;
      margin-bottom: 15px;
    }

    .addr-detail {
      font-size: 15px;
      line-height: 1.5;
      color: var(--text-color);
      max-width: 80%;
    }

    .addr-actions {
      position: absolute;
      top: 25px;
      right: 25px;
      display: flex;
      gap: 15px;
    }

    .link-action {
      color: #0d3256;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
    }

    .link-action.delete {
      color: #d9534f;
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
      }

      .content-card {
        margin-top: 10px;
        padding: 20px 15px;
      }

      .profile-header {
        display: none !important;
      }

      .btn-back {
        display: none;
      }

      .addr-actions {
        position: static;
        margin-top: 15px;
        justify-content: flex-end;
      }

      .addr-detail {
        max-width: 100%;
      }

      .top-actions {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .top-actions h1 {
        font-size: 22px;
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
    <span class="page-title">Alamat Saya</span>
    <div class="mobile-icons">
      <a href="/coding web IMK/parfy-php/dashboard">🏠</a>
      <a href="/coding web IMK/parfy-php/keranjang">🛒</a>
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
        <div class="menu-item" data-page="akun">
          <a href="/coding web IMK/parfy-php/akun">
            <svg viewBox="0 0 24 24">
              <path
                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            Akun Saya
          </a>
        </div>
        <div class="menu-item" data-page="pesanan">
          <a href="/coding web IMK/parfy-php/pesanan">
            <svg viewBox="0 0 24 24">
              <path
                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
            </svg>
            Pesanan Saya
          </a>
        </div>
        <div class="menu-item active" data-page="alamat">
          <a href="/coding web IMK/parfy-php/alamat">
            <svg viewBox="0 0 24 24">
              <path
                d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22S19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5Z" />
            </svg>
            Alamat
          </a>
        </div>
        <div class="menu-item" data-page="keranjang">
          <a href="/coding web IMK/parfy-php/keranjang">
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
      <div class="profile-header">
        <div class="icon">👤</div>
        <span>Nama</span>
      </div>

      <a class="btn-back" href="/coding web IMK/parfy-php/dashboard">← Kembali ke Dashboard</a>

      <div class="content-card">
        <div class="top-actions">
          <div>
            <h1>Alamat Saya</h1>
            <p style="color:var(--muted-text); margin:0;">Kelola alamat pengiriman parfummu.</p>
          </div>
          <button class="btn-add">
            <span>+</span> Tambah Alamat Baru
          </button>
        </div>

        <div class="address-list" id="addressList">
          <!-- Addresses will be loaded from API -->
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <div class="spinner"
              style="width:40px;height:40px;border:4px solid #ddd;border-top:4px solid var(--btn-bg);border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 20px;">
            </div>
            <p>Memuat alamat...</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add/Edit Address -->
  <div id="addressModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
    <div
      style="background:white; padding:30px; border-radius:15px; width:500px; max-width:90%; max-height:90vh; overflow-y:auto;">
      <h3 id="modalTitle" style="margin:0 0 20px;">Tambah Alamat Baru</h3>
      <form id="addressForm" autocomplete="off">
        <input type="hidden" id="addressId">
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:500;">Label Alamat</label>
          <input type="text" id="addrLabel" placeholder="Rumah, Kantor, dll" autocomplete="off"
            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:500;">Nama Penerima</label>
          <input type="text" id="addrName" placeholder="Nama lengkap" autocomplete="off"
            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;" required>
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:500;">No. Telepon</label>
          <input type="text" id="addrPhone" placeholder="08xx-xxxx-xxxx" autocomplete="off"
            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;" required>
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:500;">Alamat Lengkap</label>
          <textarea id="addrStreet" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" autocomplete="off"
            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; min-height:80px;"
            required></textarea>
        </div>
        <div style="display:flex; gap:15px; margin-bottom:15px;">
          <div style="flex:1;">
            <label style="display:block; margin-bottom:5px; font-weight:500;">Provinsi</label>
            <select id="addrProvinceId" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;"
              required onchange="loadCities(this.value)">
              <option value="">Pilih Provinsi</option>
            </select>
            <input type="hidden" id="addrProvinceName">
          </div>
          <div style="flex:1;">
            <label style="display:block; margin-bottom:5px; font-weight:500;">Kota</label>
            <select id="addrCityId" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;" required
              disabled onchange="setCityName()">
              <option value="">Pilih Kota</option>
            </select>
            <input type="hidden" id="addrCityName">
          </div>
        </div>
        <div style="margin-bottom:20px;">
          <label style="display:block; margin-bottom:5px; font-weight:500;">Kode Pos</label>
          <input type="text" id="addrPostal" placeholder="12345"
            style="width:150px; padding:10px; border:1px solid #ddd; border-radius:8px;">
        </div>
        <div style="display:flex; gap:10px; justify-content:flex-end;">
          <button type="button" onclick="closeAddressModal()"
            style="padding:10px 20px; border:1px solid #ddd; background:white; border-radius:8px; cursor:pointer;">Batal</button>
          <button type="submit"
            style="padding:10px 20px; background:var(--btn-bg); color:white; border:none; border-radius:8px; cursor:pointer;">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <style>
    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>

  <script src="/coding web IMK/parfy-php/js/api.js"></script>
  <script>
    let addresses = [];

    // Check if user is logged in
    function checkAuth() {
      const user = PARFY.getUser();
      if (!user) {
        window.location.href = '/coding web IMK/parfy-php/login';
        return false;
      }
      document.querySelector('.profile-header span').textContent = user.name || 'User';
      return true;
    }

    // Render addresses
    function renderAddresses() {
      const container = document.getElementById('addressList');

      if (addresses.length === 0) {
        container.innerHTML = `
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <div style="font-size:60px; margin-bottom:20px;">📍</div>
            <h3>Belum ada alamat</h3>
            <p>Tambahkan alamat pengiriman pertamamu.</p>
          </div>
        `;
        return;
      }

      container.innerHTML = addresses.map((addr, index) => {
        const labelText = addr.label && addr.label.trim() ? addr.label : 'Alamat';
        const namePart = addr.name && addr.name.trim() ? ` (${addr.name})` : '';
        const addressParts = [addr.street, addr.city, addr.province].filter(p => p && p.trim() !== '');
        const fullDetail = addressParts.join(', ') + (addr.postalCode ? ' ' + addr.postalCode : '');

        return `
        <div class="address-card">
          <div class="addr-name">
            ${labelText}${namePart}
            ${index === 0 ? '<span class="badge-main">Utama</span>' : ''}
          </div>
          <div class="addr-phone">${addr.phone || '-'}</div>
          <div class="addr-detail">
            ${fullDetail}
          </div>
          <div class="addr-actions">
            <a href="#" class="link-action" onclick="editAddress(${index}); return false;">Ubah</a>
            ${index > 0 ? `
              <a href="#" class="link-action delete" onclick="deleteAddress(${index}); return false;">Hapus</a>
              <a href="#" class="link-action" style="color:var(--muted-text); font-weight:400;" onclick="setMainAddress(${index}); return false;">Atur Utama</a>
            ` : ''}
          </div>
        </div>
      `;
      }).join('');
    }

    // Open modal for adding address
    function openAddressModal() {
      document.getElementById('modalTitle').textContent = 'Tambah Alamat Baru';
      document.getElementById('addressForm').reset();
      document.getElementById('addressId').value = '';
      document.getElementById('addressModal').style.display = 'flex';
      loadProvinces(); // Load provinces
    }

    // Close modal
    function closeAddressModal() {
      document.getElementById('addressModal').style.display = 'none';
    }

    // Helper: Find option by text and select it
    function selectOptionByText(selectId, text) {
      const select = document.getElementById(selectId);
      for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].text === text) {
          select.selectedIndex = i;
          return select.options[i].value;
        }
      }
      return null;
    }

    // Edit address
    async function editAddress(index) {
      const addr = addresses[index];
      document.getElementById('modalTitle').textContent = 'Ubah Alamat';
      document.getElementById('addressId').value = index;
      document.getElementById('addrLabel').value = addr.label || '';
      document.getElementById('addrName').value = addr.name || '';
      document.getElementById('addrPhone').value = addr.phone || '';
      document.getElementById('addrStreet').value = addr.street || '';
      document.getElementById('addrPostal').value = addr.postalCode || '';

      await loadProvinces(); // Wait for provinces

      // Select Province
      const provSelect = document.getElementById('addrProvinceId');
      provSelect.value = addr.provinceId || selectOptionByText('addrProvinceId', addr.province);
      document.getElementById('addrProvinceName').value = addr.province;

      if (provSelect.value) {
        await loadCities(provSelect.value); // Wait for cities

        // Select City
        const citySelect = document.getElementById('addrCityId');
        citySelect.value = addr.cityId || selectOptionByText('addrCityId', addr.city);
        document.getElementById('addrCityName').value = addr.city;
      }

      document.getElementById('addressModal').style.display = 'flex';
    }

    // Delete address
    async function deleteAddress(index) {
        const result = await Swal.fire({ title: 'Hapus alamat ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya!', cancelButtonText: 'Batal' });
        if (!result.isConfirmed) return;

      try {
        await PARFY.users.deleteAddress(addresses[index].id || index);
        await loadAddresses();
      } catch (error) {
        Swal.fire('Error!', 'Gagal menghapus alamat: ' + error.message, 'error');
      }
    }

    // Set main address
    async function setMainAddress(index) {
      try {
        // Move address to first position
        const addr = addresses.splice(index, 1)[0];
        addresses.unshift(addr);

        // Update all addresses
        await PARFY.users.updateProfile({ addresses: addresses });
        await loadAddresses();
      } catch (error) {
        Swal.fire('Error!', 'Gagal mengatur alamat utama: ' + error.message, 'error');
      }
    }

    // Save address form
    document.getElementById('addressForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const provinceSelect = document.getElementById('addrProvinceId');
      const citySelect = document.getElementById('addrCityId');

      const addrData = {
        label: document.getElementById('addrLabel').value,
        name: document.getElementById('addrName').value,
        phone: document.getElementById('addrPhone').value,
        street: document.getElementById('addrStreet').value,
        city: document.getElementById('addrCityName').value,
        cityId: citySelect.value,
        province: document.getElementById('addrProvinceName').value,
        provinceId: provinceSelect.value,
        postalCode: document.getElementById('addrPostal').value
      };

      const editIndex = document.getElementById('addressId').value;

      try {
        let response;
        if (editIndex !== '') {
          // Update existing - use PUT with address ID
          const addressId = addresses[parseInt(editIndex)].id;
          response = await fetch(`/coding web IMK/parfy-php/api/users/addresses.php?id=${addressId}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer ' + localStorage.getItem('parfy_token')
            },
            body: JSON.stringify(addrData)
          });
        } else {
          // Add new - use POST
          response = await fetch('/coding web IMK/parfy-php/api/users/addresses.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer ' + localStorage.getItem('parfy_token')
            },
            body: JSON.stringify(addrData)
          });
        }

        const resData = await response.json();
        if (!response.ok) {
          Swal.fire('Peringatan!', resData.error || 'Gagal menyimpan alamat', 'warning');
          return;
        }

        Swal.fire('Berhasil!', resData.message || 'Alamat berhasil disimpan!', 'success');
        closeAddressModal();
        await loadAddresses();
      } catch (error) {
        Swal.fire('Error!', 'Gagal menyimpan alamat: ' + error.message, 'error');
      }
    });

    // Load addresses from API
    async function loadAddresses() {
      try {
        const res = await fetch('/coding web IMK/parfy-php/api/users/addresses.php', {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('parfy_token')
          }
        });
        addresses = await res.json();
        if (!Array.isArray(addresses)) addresses = [];
        renderAddresses();
      } catch (error) {
        console.error('Error loading addresses:', error);
        document.getElementById('addressList').innerHTML = `
          <div style="text-align:center; padding:40px; color:var(--muted-text);">
            <p>Gagal memuat alamat. <a href="#" onclick="loadAddresses()">Coba lagi</a></p>
          </div>
        `;
      }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
      if (checkAuth()) {
        loadAddresses();
      }

      // Add button handler
      document.querySelector('.btn-add').addEventListener('click', openAddressModal);
    });

    // API Functions - Using BinderByte
    async function loadProvinces() {
      try {
        const res = await fetch('/coding web IMK/parfy-php/api/shipping/province.php');
        const data = await res.json();
        const select = document.getElementById('addrProvinceId');
        if (data.success && data.provinces) {
          select.innerHTML = '<option value="">Pilih Provinsi</option>' +
            data.provinces.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
        }
      } catch (e) { console.error('Gagal memuat provinsi', e); }
    }

    async function loadCities(provId) {
      // Set province name
      const provSelect = document.getElementById('addrProvinceId');
      if (provSelect.selectedIndex >= 0) {
        document.getElementById('addrProvinceName').value = provSelect.options[provSelect.selectedIndex].text;
      }

      if (!provId) return;
      try {
        const citySelect = document.getElementById('addrCityId');
        citySelect.innerHTML = '<option>Loading...</option>';
        citySelect.disabled = true;

        const res = await fetch(`/coding web IMK/parfy-php/api/shipping/city.php?province=${encodeURIComponent(provId)}`);
        const data = await res.json();

        if (data.success && data.cities) {
          citySelect.innerHTML = '<option value="">Pilih Kota</option>' +
            data.cities.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
        } else {
          citySelect.innerHTML = '<option value="">Tidak ada kota</option>';
        }
        citySelect.disabled = false;
      } catch (e) {
        console.error('Gagal memuat kota', e);
        const citySelect = document.getElementById('addrCityId');
        if (citySelect) {
          citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
          citySelect.disabled = false;
        }
      }
    }

    function setCityName() {
      const citySelect = document.getElementById('addrCityId');
      if (citySelect.selectedIndex >= 0) {
        document.getElementById('addrCityName').value = citySelect.options[citySelect.selectedIndex].text;
      }
    }

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
