<?php require_once __DIR__ . '/../config/database.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Akun Saya</title>
  <style>
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

    /* Sidebar */
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
      opacity: 1;
      transition: opacity 0.5s ease-in-out;
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
      transition: background 0.3s;
    }

    .profile-card {
      background: var(--card-bg);
      padding: 40px 50px;
      border-radius: 25px;
      margin-top: 60px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h1 {
      margin-top: 0;
      margin-bottom: 30px;
      font-size: 28px;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .form-group label {
      width: 130px;
      font-size: 15px;
      color: var(--muted-text);
      font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="email"] {
      width: 420px;
      height: 40px;
      padding: 8px 12px;
      font-size: 15px;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      outline: none;
      transition: border-color 0.3s;
    }

    .form-group input:focus {
      border-color: var(--text-color);
    }

    .radio-group {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .date-group {
      display: flex;
      gap: 15px;
    }

    .date-group select {
      width: 120px;
      height: 38px;
      padding: 8px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
    }

    .btn-save {
      margin-top: 30px;
      background: var(--btn-bg);
      color: var(--btn-text);
      padding: 12px 40px;
      border: none;
      font-size: 18px;
      border-radius: 8px;
      cursor: pointer;
      transition: background .3s;
    }

    .btn-save:hover {
      background: #0a2a4a;
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

    @media (max-width: 1024px) {
      .sidebar {
        width: 250px;
        padding: 30px 20px;
      }

      .main {
        padding: 30px 40px;
      }

      .form-group input[type="text"],
      .form-group input[type="email"] {
        width: 300px;
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

      .profile-card {
        margin-top: 10px;
        padding: 20px 15px;
      }

      .profile-header {
        display: none !important;
      }

      .btn-back {
        display: none;
      }

      .form-group {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .form-group label {
        width: auto;
      }

      .form-group input[type="text"],
      .form-group input[type="email"] {
        width: 100%;
      }

      .date-group {
        flex-direction: column;
        width: 100%;
      }

      .date-group select {
        width: 100%;
        margin-bottom: 10px;
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
    <span class="page-title">Akun Saya</span>
    <div class="mobile-icons">
      <a href="<?php echo url('/dashboard'); ?>">🏠</a>
      <a href="<?php echo url('/keranjang'); ?>">🛒</a>
    </div>
  </div>

  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="logo">
        <img src="<?php echo url('/assets/'); ?>logo_parfum_bk.png" alt="Logo">
        <h2>PARFY.ID</h2>
        <p>TOKO PARFUM TERMURAH</p>
      </div>

      <div class="menu">
        <div class="menu-item active" data-page="akun">
          <a href="<?php echo url('/akun'); ?>">
            <svg viewBox="0 0 24 24">
              <path
                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            Akun Saya
          </a>
        </div>
        <div class="menu-item" data-page="pesanan">
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

    <!-- Main Content -->
    <div class="main" id="main-content">
      <div class="profile-header">
        <div class="icon">👤</div>
        <span>Nama</span>
      </div>

      <a class="btn-back" href="<?php echo url('/dashboard'); ?>">← Kembali ke Dashboard</a>

      <div class="profile-card">
        <h1>Profil Saya</h1>

        <form id="profile-form">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Masukkan username" required />
          </div>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" placeholder="Masukkan nama lengkap" required />
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Masukkan email" required />
          </div>

          <div class="form-group">
            <label for="telp">No. Telp.</label>
            <input type="text" id="telp" placeholder="Masukkan nomor telepon" required />
          </div>

          <div class="form-group">
            <label>Jenis Kelamin</label>
            <div class="radio-group">
              <label><input type="radio" name="gender" value="Laki-Laki" /> Laki-Laki</label>
              <label><input type="radio" name="gender" value="Perempuan" /> Perempuan</label>
              <label><input type="radio" name="gender" value="Lainnya" /> Lainnya</label>
            </div>
          </div>

          <div class="form-group">
            <label>Tanggal Lahir</label>
            <div class="date-group">
              <select id="tanggal" required>
                <option value="">Tanggal</option>
                <script>for (let i = 1; i <= 31; i++) document.write(`<option value="${i}">${i}</option>`);</script>
              </select>
              <select id="bulan" required>
                <option value="">Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
              <select id="tahun" required>
                <option value="">Tahun</option>
                <script>for (let i = 2023; i >= 1900; i--) document.write(`<option value="${i}">${i}</option>`);</script>
              </select>
            </div>
          </div>

          <button type="submit" class="btn-save">Simpan</button>
        </form>
      </div>
    </div>
  </div>

  <script src="<?php echo url('/js/api.js'); ?>"></script>
  <script>
    // Check if user is logged in
    function checkAuth() {
      const user = PARFY.getUser();
      if (!user) {
        window.location.href = BASE_PATH + '/login';
        return false;
      }
      document.querySelector('.profile-header span').textContent = user.name || 'User';
      return true;
    }

    // Load profile data
    async function loadProfile() {
      try {
        const user = await PARFY.users.me();

        // Fill form with user data
        document.getElementById('username').value = user.name?.split(' ')[0] || '';
        document.getElementById('nama').value = user.name || '';
        document.getElementById('email').value = user.email || '';
        document.getElementById('telp').value = user.phone || '';

        // Gender
        if (user.gender) {
          const genderRadio = document.querySelector(`input[name="gender"][value="${user.gender}"]`);
          if (genderRadio) genderRadio.checked = true;
        }

        // Birth date
        if (user.birthDate) {
          const date = new Date(user.birthDate);
          document.getElementById('tanggal').value = date.getDate();
          document.getElementById('bulan').value = date.getMonth() + 1;
          document.getElementById('tahun').value = date.getFullYear();
        }
      } catch (error) {
        console.error('Error loading profile:', error);
      }
    }

    // Save profile
    document.getElementById('profile-form').addEventListener('submit', async function (e) {
      e.preventDefault();

      const username = document.getElementById('username').value.trim();
      const nama = document.getElementById('nama').value.trim();
      const email = document.getElementById('email').value.trim();
      const telp = document.getElementById('telp').value.trim();
      const gender = document.querySelector('input[name="gender"]:checked')?.value;
      const tanggal = document.getElementById('tanggal').value;
      const bulan = document.getElementById('bulan').value;
      const tahun = document.getElementById('tahun').value;

      if (!nama || !email) {
        Swal.fire('Peringatan!', 'Nama dan Email wajib diisi!', 'warning');
        return;
      }

      try {
        const birthDate = tanggal && bulan && tahun
          ? new Date(tahun, bulan - 1, tanggal).toISOString()
          : null;

        await PARFY.users.updateProfile({
          name: nama,
          phone: telp,
          gender: gender,
          birthDate: birthDate
        });

        Swal.fire('Berhasil!', 'Profil berhasil disimpan!', 'success');
      } catch (error) {
        Swal.fire('Error!', 'Gagal menyimpan profil: ' + error.message, 'error');
      }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
      if (checkAuth()) {
        loadProfile();
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
